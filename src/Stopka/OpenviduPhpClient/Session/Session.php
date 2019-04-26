<?php
/**
 * Created by IntelliJ IDEA.
 * User: stopka
 * Date: 13.10.17
 * Time: 12:51
 */

namespace Stopka\OpenviduPhpClient\Session;

use Stopka\OpenviduPhpClient\EnumException;
use Stopka\OpenviduPhpClient\MediaModeEnum;
use Stopka\OpenviduPhpClient\OpenVidu;
use Stopka\OpenviduPhpClient\OpenViduException;
use Stopka\OpenviduPhpClient\OpenViduRoleEnum;
use Stopka\OpenviduPhpClient\Recording\RecordingModeEnum;
use Stopka\OpenviduPhpClient\Recording\RecordingOutputModeEnum;
use Stopka\OpenviduPhpClient\Rest\RestClient;
use Stopka\OpenviduPhpClient\Rest\RestClientException;
use Stopka\OpenviduPhpClient\Session\Token\TokenOptions;
use Stopka\OpenviduPhpClient\Session\Token\TokenOptionsBuilder;

class Session
{
    private const TOKEN_URL = "api/tokens";
    private const SESSION_URL = "api/sessions";

    /** @var  RestClient */
    private $restClient;

    /** @var  string */
    private $sessionId;

    /** @var \DateTime */
    private $createdAt;

    /** @var SessionProperties */
    private $properties;

    /** @var Connection[] */
    private $activeConnections = [];

    /** @var bool */
    private $recording = false;

    public static function createFromProperties(RestClient $restClient, ?SessionProperties $properties = null): self
    {
        return new self($restClient, $properties);
    }

    /**
     * @param RestClient $restClient
     * @param array $data
     * @return Session
     * @throws EnumException
     */
    public static function createFromArray(RestClient $restClient, array $data): self
    {
        $session = new self($restClient, null, $data['sessionId']);
        $session->resetSessionWithDataArray($data);
        return $session;
    }

    /**
     * Session constructor.
     * @param RestClient $restClient
     * @param null|SessionProperties $properties
     * @param null|string $sessionId
     * @throws OpenViduException
     */
    protected function __construct(
        RestClient $restClient,
        ?SessionProperties $properties = null,
        ?string $sessionId = null
    ) {
        $this->restClient = $restClient;
        if (!$properties) {
            $properties = (new SessionPropertiesBuilder())->build();
        }
        $this->properties = $properties;
        $this->sessionId = $this->retrieveSessionId($sessionId);
    }

    /**
     * @return string
     * @throws OpenViduException
     */
    public function getSessionId(): string
    {
        return $this->sessionId;
    }

    /**
     * @return \DateTime
     */
    public function getCreatedAt(): \DateTime
    {
        return $this->createdAt;
    }

    /**
     * @param null|TokenOptions $tokenOptions
     * @return string
     * @throws OpenViduException
     * @throws EnumException
     */
    public function generateToken(?TokenOptions $tokenOptions = null): string
    {
        if (!$tokenOptions) {
            $tokenOptions = $this->getDefaultTokenOptions();
        }
        try {
            $data = [
                "session" => $this->getSessionId(),
                "role" => $tokenOptions->getRole(),
                "data" => $tokenOptions->getData(),
                "kurentoOptions" => $tokenOptions->getKurentoOptions()->getDataArray()
            ];
            return $this->restClient->post(self::TOKEN_URL, $data)->getStringInArrayKey('id');
        } catch (RestClientException $e) {
            throw new OpenViduException("Could not retrieve token", 0, $e);
        }
    }

    /**
     * @return TokenOptions
     * @throws EnumException
     */
    private function getDefaultTokenOptions(): TokenOptions
    {
        $builder = new TokenOptionsBuilder();
        $builder->setRole(new OpenViduRoleEnum(OpenViduRoleEnum::PUBLISHER));
        return $builder->build();
    }

    /**
     *
     */
    public function close(): void
    {
        try {
            $this->restClient->delete(OpenVidu::SESSIONS_URL . '/' . $this->sessionId);
        } catch (RestClientException $e) {
            throw new OpenViduException("Unable to close session", 0, $e);
        }
    }

    /**
     * @throws EnumException
     */
    public function fetch(): bool
    {
        try {
            $beforeArray = $this->toDataArray();
            $data = $this->restClient->get(OpenVidu::SESSIONS_URL . '/' . $this->sessionId)
                ->getArray();
            $this->resetSessionWithDataArray($data);
            $hasChanged = json_encode($this->toDataArray()) !== json_encode($beforeArray);
            return $hasChanged;
        } catch (RestClientException $e) {
            throw new OpenViduException("Unable to fetch session", 0, $e);
        }
    }

    public function forceDisconnect(string $connectionId): void
    {
        try {
            $this->restClient->delete(OpenVidu::SESSIONS_URL . '/' . $this->sessionId . '/connection/' . $connectionId);
            $connectionClosed = $this->activeConnections[$connectionId] ?? null;
            unset($this->activeConnections[$connectionId]);
            if ($connectionClosed) {
                foreach ($connectionClosed->getPublishers() as $publisher) {
                    $streamId = $publisher->getStreamId();
                    foreach ($this->activeConnections as $connection) {
                        $subscribers = $connection->getSubscribers();
                        $subscribers = array_filter($subscribers, function ($subscriber) use ($streamId) {
                            return $streamId !== $subscriber;
                        });
                        $connection->setSubscribers($subscribers);
                    }
                }
            }

            // Remove every Publisher of the closed connection from every subscriber list of
            // other connections
        } catch (RestClientException $e) {
            throw new OpenViduException("Disconnecting failed", 0, $e);
        }
    }

    public function forceUnpublish(string $streamId)
    {
        try {
            $this->restClient->delete(OpenVidu::SESSIONS_URL . '/' . $this->sessionId . '/stream/' . $streamId);
        } catch (RestClientException $e) {
            throw new OpenViduException("Unpublishing failed", 0, $e);
        }
    }

    /**
     * @return Connection[]
     */
    public function getActiveConnections(): array
    {
        return clone $this->activeConnections;
    }

    public function isBeingRecorded(): bool
    {
        return $this->recording;
    }

    public function getProperties(): SessionProperties
    {
        return $this->properties;
    }

    public function __toString()
    {
        return $this->sessionId;
    }

    public function hasSessionId(): bool
    {
        return $this->sessionId && strlen($this->sessionId);
    }

    /**
     * @param string|null $sesstionId
     * @return string
     * @throws OpenViduException
     */
    private function retrieveSessionId(?string $sesstionId = null): string
    {
        if ($sesstionId) {
            return $sesstionId;
        }
        try {
            return $this->restClient->post(self::SESSION_URL, [
                "mediaMode" => $this->properties->getMediaMode(),
                "recordingMode" => $this->properties->getRecordingMode(),
                "defaultRecordingLayout" => $this->properties->getDefaultRecordingLayout(),
                "defaultCustomLayout" => $this->properties->getDefaultCustomLayout(),
                "customSessionId" => $this->properties->getCustomSessionId(),
            ])->getStringInArrayKey('id');
        } catch (RestClientException $e) {
            throw new OpenViduException("Unable to generate a sessionId", 0, $e);
        }
    }

    public function setIsBeingRecorded(bool $recording): void
    {
        $this->recording = $recording;
    }

    /**
     * @param array $data
     * @throws EnumException
     */
    public function resetSessionWithDataArray(array $data): void
    {
        $this->sessionId = (string)$data['sessionId'];
        $this->createdAt = (new \DateTime())->setTimestamp($data['createdAt']);
        $this->recording = (bool)$data['recording'];
        $builder = new SessionPropertiesBuilder();
        $builder->setMediaMode(new MediaModeEnum($data['mediaMode']))
            ->setRecordingMode(new RecordingModeEnum($data['recordingMode']))
            ->setDefaultOutputMode(new RecordingOutputModeEnum($data['defaultOutputMode']));
        if (isset($data['defaultRecordingLayout'])) {
            $builder->setDefaultRecordingLayout($data['defaultRecordingLayout']);
        }
        if (isset($data['defaultCustomLayout'])) {
            $builder->setDefaultCustomLayout($data['defaultCustomLayout']);
        }
        if ($this->properties && $this->properties->getCustomSessionId()) {
            $builder->setCustomSessionId($this->properties->getCustomSessionId());
        }
        $this->properties = $builder->build();
        $this->activeConnections = [];
        foreach ($data['connections'] as $arrayConnection) {
            $connection = Connection::createFromDataArray($arrayConnection);
            $this->activeConnections[$connection->getConnectionId()] = $connection;
        }
    }

    public function toDataArray(): array
    {
        $connections = [];
        foreach ($this->activeConnections as $connection) {
            $connections[] = $connection->getDataArray();
        }
        return [
            'sessionId' => $this->sessionId,
            'createdAt' => $this->createdAt->getTimestamp(),
            'customSessionId' => $this->properties->getCustomSessionId(),
            'recording' => $this->recording,
            'mediaMode' => (string)$this->properties->getMediaMode(),
            'recordingMode' => (string)$this->properties->getRecordingMode(),
            'defaultOutputMode' => (string)$this->properties->getDefaultOutputMode(),
            'defaultRecordingLayout' => (string)$this->properties->getDefaultRecordingLayout(),
            'defaultCustomLayout' => $this->properties->getDefaultCustomLayout(),
            'connections' => [
                'numberOfElements' => count($connections),
                'content' => $connections
            ]
        ];
    }


}

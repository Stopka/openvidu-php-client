<?php
/**
 * Created by IntelliJ IDEA.
 * User: stopka
 * Date: 13.10.17
 * Time: 12:19
 */

namespace Stopka\OpenviduPhpClient;


use Stopka\OpenviduPhpClient\Recording\Recording;
use Stopka\OpenviduPhpClient\Recording\RecordingLayoutEnum;
use Stopka\OpenviduPhpClient\Recording\RecordingOutputModeEnum;
use Stopka\OpenviduPhpClient\Recording\RecordingProperties;
use Stopka\OpenviduPhpClient\Recording\RecordingPropertiesBuilder;
use Stopka\OpenviduPhpClient\Rest\RestClient;
use Stopka\OpenviduPhpClient\Rest\RestClientException;
use Stopka\OpenviduPhpClient\Session\Session;
use Stopka\OpenviduPhpClient\Session\SessionProperties;

class OpenVidu
{
    protected const HTTP_USERNAME = "OPENVIDUAPP";

    const SESSIONS_URL = "api/sessions";
    const TOKENS_URL = "api/tokens";
    const RECORDINGS_URL = "api/recordings";
    const RECORDINGS_START_URL = "api/recordings/start";
    const RECORDINGS_STOP_URL = "api/recordings/stop";

    /** @var  string */
    protected $urlOpenViduServer;

    /** @var string */
    protected $secret;

    /** @var bool */
    protected $sslCheck = true;

    /** @var RestClient */
    protected $restClient;

    /** @var Session[] */
    protected $activeSessions = [];

    /**
     * OpenVidu constructor.
     * @param string $urlOpenViduServer
     * @param string $secret
     * @param bool   $sslCheck
     */
    public function __construct(string $urlOpenViduServer, string $secret, bool $sslCheck = true)
    {
        $this->secret = $secret;
        $this->sslCheck = $sslCheck;
        $this->urlOpenViduServer = $urlOpenViduServer;
        $this->restClient = $this->buildRestClient();
    }

    /**
     * @param SessionProperties|null $properties
     * @return Session
     * @throws OpenViduException
     */
    public function createSession(?SessionProperties $properties = null): Session
    {
        $session = Session::createFromProperties($this->restClient, $properties);
        $this->activeSessions[$session->getSessionId()] = $session;
        return $session;
    }

    /**
     * @param SessionProperties|null $properties
     * @return Session|null
     */
    public function createSessionFromDataArray(array $data): ?Session
    {
        try {
            $session = Session::createFromArray($this->restClient, $data);
            $this->activeSessions[$session->getSessionId()] = $session;
            return $session;
        }catch (EnumException $e){
            return null;
        }
    }

    /**
     * @return RestClient
     */
    private function buildRestClient(): RestClient
    {
        $client = new RestClient($this->urlOpenViduServer, self::HTTP_USERNAME, $this->secret, $this->sslCheck);
        return $client;
    }

    /**
     * @param string $sessionId
     * @param null|RecordingProperties $properties
     * @return Recording
     * @throws OpenViduException
     */
    public function startRecording(string $sessionId, ?RecordingProperties $properties = null): Recording
    {
        if (!$properties) {
            $properties = (new RecordingPropertiesBuilder())->build();
        }
        try {
            $data = [
                "session" => $sessionId,
                "name" => $properties->getName(),
                "outputMode" => (string)$properties->getOutputMode(),
                'hasAudio' => $properties->isHasAudio(),
                'hasVideo' => $properties->isHasVideo()
            ];
            if ($properties->getOutputMode()->equalsString(RecordingOutputModeEnum::COMPOSED)) {
                $data['resolution'] = $properties->getResolution();
                $data['recordingLayout'] = (string)($properties->getRecordingLayout() ?? "");
                if ($properties->getRecordingLayout()->equalsString(RecordingLayoutEnum::CUSTOM)) {
                    $data['customLayout'] = $properties->getCustomLayout() ?? "";
                }
            }
            $arrayRecording = $this->restClient->post(self::RECORDINGS_START_URL, $data)->getArray();

            return new Recording($arrayRecording);
        } catch (RestClientException $e) {
            throw new OpenViduException("Could not start recording", 0, $e);
        } catch (EnumException $e) {
            throw new OpenViduException("Could not start recording", 0, $e);
        }
    }

    /**
     * @param string $recordingId
     * @return Recording
     * @throws OpenViduException
     */
    public function stopRecording(string $recordingId): Recording
    {
        try {
            $arrayRecording = $this->restClient->post(self::RECORDINGS_STOP_URL . '/' . $recordingId)
                ->getArray();
            return new Recording($arrayRecording);
        } catch (RestClientException $e) {
            throw new OpenViduException("Could not stop recording", 0, $e);
        } catch (EnumException $e) {
            throw new OpenViduException("Could not stop recording", 0, $e);
        }
    }

    /**
     * @param string $recordingId
     * @return Recording
     * @throws OpenViduException
     */
    public function getRecording(string $recordingId): Recording
    {
        try {
            $arrayRecording = $this->restClient->get(self::RECORDINGS_URL . '/' . $recordingId)->getArray();
            return new Recording($arrayRecording);
        } catch (RestClientException $e) {
            throw new OpenViduException("Could not retrieve recording", 0, $e);
        } catch (EnumException $e) {
            throw new OpenViduException("Could not retrieve recording", 0, $e);
        }
    }

    /**
     * @return Recording[]
     * @throws OpenViduException
     */
    public function listRecordings(): array
    {
        try {
            $items = $this->restClient->get(self::RECORDINGS_URL)->getArrayInArrayKey('items');

            $recordings = [];
            foreach ($items as $itemValues) {
                $recordings[] = new Recording($itemValues);
            }
            return $recordings;
        } catch (RestClientException $e) {
            throw new OpenViduException("Could not retrieve recordings", 0, $e);
        } catch (EnumException $e) {
            throw new OpenViduException("Could not retrieve recordings", 0, $e);
        }
    }

    /**
     * @param string $recordingId
     * @throws OpenViduException
     */
    public function deleteRecording(string $recordingId): void
    {
        try {
            $this->restClient->delete(self::RECORDINGS_URL . '/' . $recordingId);
        } catch (RestClientException $e) {
            throw new OpenViduException("Could not delete recording", 0, $e);
        }
    }


    /**
     * @return Session[]
     */
    public function getActiveSessions(): array
    {
        return $this->activeSessions;
    }

    /**
     * @return bool
     * @throws OpenViduException
     */
    public function fetch(): bool
    {
        try {
            $jsonArraySessions = $this->restClient->get(self::SESSIONS_URL)->getArrayInArrayKey('content');

            // Set to store fetched sessionIds and later remove closed sessions
            $fetchedSessionIds = [];
            // Boolean to store if any Session has changed
            $hasChanged = false;

            foreach ($jsonArraySessions as $arraySession) {
                $sessionId = $arraySession["sessionId"];
                $fetchedSessionIds[] = $sessionId;
                if (isset($this->activeSessions[$sessionId])) {
                    $session = $this->activeSessions[$sessionId];
                    $beforeArray = $session->toDataArray();
                    $session->resetSessionWithDataArray($arraySession);
                    $afterArray = $session->toDataArray();
                    $changed = json_encode($beforeArray) !== json_encode($afterArray);
                    $hasChanged = $hasChanged || $changed;
                } else {
                    $hasChanged = true;
                    $this->activeSessions[$sessionId] = Session::createFromArray($this->restClient, $arraySession);
                }
            }
            foreach ($this->activeSessions as $key => $session) {
                if (!in_array($key, $fetchedSessionIds)) {
                    $hasChanged = true;
                    unset($this->activeSessions[$key]);
                }
            }
            return $hasChanged;
        } catch (RestClientException $e) {
            throw new OpenViduException('Sessions fetching failed', 0, $e);
        } catch (EnumException $e) {
            throw new OpenViduException('Sessions fetching failed', 0, $e);
        }
    }


}

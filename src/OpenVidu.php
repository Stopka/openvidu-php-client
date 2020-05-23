<?php

declare(strict_types=1);

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

    /** @var RestClient */
    protected RestClient $restClient;

    /** @var array<string,Session> */
    protected array $activeSessions = [];

    /**
     * OpenVidu constructor.
     *
     * @param RestClient $restClient
     */
    public function __construct(RestClient $restClient)
    {
        $this->restClient = $restClient;
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
     * @param mixed[] $data
     * @return Session
     * @throws OpenViduException
     */
    public function createSessionFromDataArray(array $data): Session
    {
        try {
            $session = Session::createFromArray($this->restClient, $data);
            $this->activeSessions[$session->getSessionId()] = $session;

            return $session;
        } catch (InvalidDataException $exception) {
            throw new OpenViduException('Could not create session', 0, $exception);
        }
    }

    /**
     * @param string $sessionId
     * @param null|RecordingProperties $properties
     * @return Recording
     * @throws OpenViduException
     */
    public function startRecording(string $sessionId, ?RecordingProperties $properties = null): Recording
    {
        if (null === $properties) {
            $properties = (new RecordingPropertiesBuilder())->build();
        }
        try {
            $data = [
                'session' => $sessionId,
                'name' => $properties->getName(),
                'outputMode' => (string)$properties->getOutputMode(),
                'hasAudio' => $properties->isHasAudio(),
                'hasVideo' => $properties->isHasVideo(),
            ];
            if ($properties->getOutputMode()->equalsString(RecordingOutputModeEnum::COMPOSED)) {
                $data['resolution'] = (string)$properties->getResolution();
                $data['recordingLayout'] = (string)$properties->getRecordingLayout();
                if ($properties->getRecordingLayout()->equalsString(RecordingLayoutEnum::CUSTOM)) {
                    $data['customLayout'] = $properties->getCustomLayout() ?? '';
                }
            }
            $arrayRecording = $this->restClient->post(ApiPaths::RECORDINGS_START, $data)->getArray();

            return new Recording($arrayRecording);
        } catch (RestClientException | InvalidDataException $e) {
            throw new OpenViduException('Could not start recording', 0, $e);
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
            $arrayRecording = $this->restClient->post(ApiPaths::RECORDINGS_STOP . '/' . $recordingId)
                ->getArray();

            return new Recording($arrayRecording);
        } catch (RestClientException | InvalidDataException $e) {
            throw new OpenViduException('Could not stop recording', 0, $e);
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
            $arrayRecording = $this->restClient->get(ApiPaths::RECORDINGS . '/' . $recordingId)->getArray();

            return new Recording($arrayRecording);
        } catch (RestClientException | InvalidDataException $e) {
            throw new OpenViduException('Could not retrieve recording', 0, $e);
        }
    }

    /**
     * @return Recording[]
     * @throws OpenViduException
     */
    public function listRecordings(): array
    {
        try {
            $items = $this->restClient->get(ApiPaths::RECORDINGS)->getArrayInArrayKey('items');

            $recordings = [];
            foreach ($items as $itemValues) {
                $recordings[] = new Recording($itemValues);
            }

            return $recordings;
        } catch (RestClientException | InvalidDataException $e) {
            throw new OpenViduException('Could not retrieve recordings', 0, $e);
        }
    }

    /**
     * @param string $recordingId
     * @throws OpenViduException
     */
    public function deleteRecording(string $recordingId): void
    {
        try {
            $this->restClient->delete(ApiPaths::RECORDINGS . '/' . $recordingId);
        } catch (RestClientException $e) {
            throw new OpenViduException('Could not delete recording', 0, $e);
        }
    }


    /**
     * @return array<string,Session> sessionId => session
     */
    public function getActiveSessions(): array
    {
        return array_map(
            fn(Session $session): Session => clone $session,
            $this->activeSessions
        );
    }

    /**
     * @return bool session data changed
     * @throws OpenViduException
     */
    public function fetch(): bool
    {
        try {
            $arraySessions = $this->restClient->get(ApiPaths::SESSIONS)->getArrayInArrayKey('content');

            // Set to store fetched sessionIds and later remove closed sessions
            $fetchedSessionIds = [];
            // Boolean to store if any Session has changed
            $sessionListChanged = false;

            foreach ($arraySessions as $arraySession) {
                $sessionId = $arraySession['sessionId'];
                $fetchedSessionIds[] = $sessionId;
                if (isset($this->activeSessions[$sessionId])) {
                    $session = $this->activeSessions[$sessionId];
                    $beforeArray = $session->toDataArray();
                    $session->resetSessionWithDataArray($arraySession);
                    $afterArray = $session->toDataArray();
                    $sessionChanged = json_encode($beforeArray) !== json_encode($afterArray);
                    $sessionListChanged = $sessionListChanged || $sessionChanged;
                } else {
                    $sessionListChanged = true;
                    $this->activeSessions[$sessionId] = Session::createFromArray($this->restClient, $arraySession);
                }
            }
            foreach ($this->activeSessions as $key => $session) {
                if (!in_array($key, $fetchedSessionIds, true)) {
                    $sessionListChanged = true;
                    unset($this->activeSessions[$key]);
                }
            }

            return $sessionListChanged;
        } catch (RestClientException | InvalidDataException $exception) {
            throw new OpenViduException('Sessions fetching failed', 0, $exception);
        }
    }
}

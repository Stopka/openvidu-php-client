<?php
/**
 * Created by IntelliJ IDEA.
 * User: stopka
 * Date: 13.10.17
 * Time: 12:19
 */

namespace Stopka\OpenviduPhpClient;


class OpenVidu {
    private const HTTP_USERNAME = "OPENVIDUAPP";

    private const RECORDINGS_URL = "api/recordings";
    private const RECORDINGS_START_URL = "api/recordings/start";
    private const RECORDINGS_STOP_URL = "api/recordings/stop";

    /** @var  string */
    private $urlOpenViduServer;

    /** @var string */
    private $secret;

    /** @var RestClient */
    private $restClient;

    /**
     * OpenVidu constructor.
     * @param string $urlOpenViduServer
     * @param string $secret
     */
    public function __construct(string $urlOpenViduServer, string $secret) {
        $this->secret = $secret;
        $this->urlOpenViduServer = $urlOpenViduServer;
        $this->restClient = $this->buildRestClient();
    }

    /**
     * @param bool $value
     */
    public function enableSslCheck(bool $value = true): void {
        $httpClient = $this->restClient->getHttpClient();
        $httpClient->disableSSLHostVerification(!$value);
        $httpClient->disableSSLPeerVerification(!$value);
    }

    /**
     * @param SessionProperties|null $properties
     * @return Session
     * @throws OpenViduException
     */
    public function createSession(?SessionProperties $properties = null): Session {
        return new Session($this->restClient, $properties);
    }

    /**
     * @return Client
     */
    private function buildRestClient(): RestClient {
        $client = new RestClient($this->urlOpenViduServer,self::HTTP_USERNAME, $this->secret);
        return $client;
    }

    /**
     * @param string $sessionId
     * @param null|RecordingProperties $properties
     * @return Recording
     * @throws OpenViduException
     */
    public function startRecording(string $sessionId, ?RecordingProperties $properties = null): Recording {
        if (!$properties) {
            $properties = (new RecordingPropertiesBuilder())->build();
        }
        try {
            $result = $this->restClient->post(self::RECORDINGS_START_URL, [
                "session" => $sessionId,
                "name" => $properties->getName() ?? "",
                "recordingLayout" => $properties->getRecordingLayout() ?? "",
                "customLayout" => $properties->getCustomLayout() ?? ""
            ]);
        } catch (RestClientException $e) {
            throw new OpenViduException("Could not start recording", OpenViduException::CODE_GENERIC, $e);
        }
        return new Recording($result);
    }

    /**
     * @param string $recordingId
     * @return Recording
     * @throws OpenViduException
     */
    public function stopRecording(string $recordingId): Recording {
        try {
            $result = $this->restClient->post(self::RECORDINGS_STOP_URL . '/' . $recordingId);
        } catch (RestClientException $e) {
            throw new OpenViduException("Could not stop recording", OpenViduException::CODE_GENERIC, $e);
        }
        return new Recording($result);
    }

    /**
     * @param string $recordingId
     * @return Recording
     * @throws OpenViduException
     */
    public function getRecording(string $recordingId): Recording {
        try {
            $result = $this->restClient->get(self::RECORDINGS_URL . '/' . $recordingId);
        } catch (RestClientException $e) {
            throw new OpenViduException("Could not retrieve recording", OpenViduException::CODE_GENERIC, $e);
        }
        return new Recording($result);
    }

    /**
     * @return Recording[]
     * @throws OpenViduException
     */
    public function listRecordings(): array {
        try {
            $result = $this->restClient->get(self::RECORDINGS_URL);
        } catch (RestClientException $e) {
            throw new OpenViduException("Could not retrieve recordings", OpenViduException::CODE_GENERIC, $e);
        }
        $recordings = [];
        foreach ($result['items'] as $itemValues) {
            $recordings[] = new Recording($itemValues);
        }
        return $recordings;
    }

    /**
     * @param string $recordingId
     * @throws OpenViduException
     */
    public function deleteRecording(string $recordingId): void {
        try {
            $this->restClient->delete(self::RECORDINGS_URL . '/' . $recordingId);
        } catch (RestClientException $e) {
            throw new OpenViduException("Could not delete recordings", OpenViduException::CODE_GENERIC, $e);
        }
    }
}
<?php
/**
 * Created by IntelliJ IDEA.
 * User: stopka
 * Date: 13.10.17
 * Time: 12:51
 */

namespace Stopka\OpenviduPhpClient;

use Stopka\OpenviduPhpClient\TokenOptions\TokenOptionsBuilder;
use Stopka\SimpleRest\Rest\RestClient;
use Stopka\SimpleRest\Rest\RestClientException;

class Session {
    private const TOKEN_URL = "api/tokens";
    private const SESSION_URL = "api/sessions";

    /** @var  RestClient */
    private $restClient;

    /** @var  string */
    private $sessionId;

    /** @var SessionProperties */
    private $properties;

    /**
     * Session constructor.
     * @param RestClient $restClient
     * @param null|SessionProperties $properties
     * @throws OpenViduException
     */
    public function __construct(RestClient $restClient, ?SessionProperties $properties = null) {
        $this->restClient = $restClient;
        if (!$properties) {
            $properties = new SessionProperties();
        }
        $this->properties = $properties;
        $this->sessionId = $this->retrieveSessionId();
    }

    /**
     * @return bool
     */
    private function hasSassionId(): bool {
        return $this->sessionId !== null && strlen($this->sessionId) > 0;
    }

    /**
     * @return string
     * @throws OpenViduException
     */
    public function getSessionId(): string {
        if (!$this->hasSassionId()) {
            return $this->retrieveSessionId();
        }
        return $this->sessionId;
    }

    /**
     * @return string
     * @throws OpenViduException
     */
    private function retrieveSessionId(): string {
        try {
            $result = $this->restClient->post(self::SESSION_URL, [
                "mediaMode" => $this->properties->getMediaMode(),
                "recordingMode" => $this->properties->getRecordingMode(),
                "defaultRecordingLayout" => $this->properties->getDefaultRecordingLayout(),
                "defaultCustomLayout" => $this->properties->getDefaultCustomLayout(),
                "customSessionId" => $this->properties->getCustomSessionId(),
            ]);
        } catch (RestClientException $e) {
            throw new OpenViduException("Unable to generate a sessionId", OpenViduException::CODE_SESSIONID_CANNOT_BE_CREATED, $e);
        }
        return $result['id'];
    }

    /**
     * @param null|TokenOptions $tokenOptions
     * @return string
     * @throws OpenViduException
     */
    public function generateToken(?TokenOptions $tokenOptions = null): string {
        if (!$tokenOptions) {
            $tokenOptions = $this->getDefaultTokenOptions();
        }
        try {
            $result = $this->restClient->post(self::TOKEN_URL, [
                "session" => $this->getSessionId(),
                "role" => $tokenOptions->getRole(),
                "data" => $tokenOptions->getData()
            ]);
        } catch (RestClientException $e) {
            throw new OpenViduException("Could not retrieve token", OpenViduException::CODE_TOKEN_CANNOT_BE_CREATED, $e);
        }
        return $result['id'];
    }

    /**
     * @return TokenOptions
     */
    private function getDefaultTokenOptions(): TokenOptions {
        $builder = new TokenOptionsBuilder();
        $builder->setRole(OpenViduRole::PUBLISHER);
        return $builder->build();
    }

    /**
     * @return string
     */
    public function __toString(): string {
        return $this->getSessionId();
    }


}
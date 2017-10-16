<?php
/**
 * Created by IntelliJ IDEA.
 * User: stopka
 * Date: 13.10.17
 * Time: 12:51
 */

namespace Stopka\OpenviduPhpClient;


use Stopka\OpenviduPhpClient\Http\HttpClient;
use Stopka\OpenviduPhpClient\TokenOptions\TokenOptionsBuilder;

class Session {
    private const TOKEN_URL = "api/tokens";
    private const SESSION_URL = "api/sessions";

    /** @var  HttpClient */
    private $httpClient;

    /** @var  string */
    private $sessionId;

    /**
     * Session constructor.
     * @param HttpClient $httpClient
     * @throws OpenViduException
     */
    public function __construct(HttpClient $httpClient) {
        $this->httpClient = $httpClient;
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
            $response = $this->httpClient->post(self::SESSION_URL);
            $result = json_decode($response);
            return $result['id'];
        } catch (\Exception $e) {
            throw new OpenViduException("Unable to generate a sessionId", OpenViduException::CODE_SESSIONID_CANNOT_BE_CREATED, $e);
        }
    }

    /**
     * @param null|TokenOptions $tokenOptions
     * @return string
     * @throws OpenViduException
     */
    public function generateToken(?TokenOptions $tokenOptions = null): string {
        try {
            if (!$tokenOptions) {
                $tokenOptions = $this->getDefaultTokenOptions();
            }
            $jsonData = json_encode([
                "session" => $this->getSessionId(),
                "role" => $tokenOptions->getRole(),
                "data" => $tokenOptions->getData()
            ]);
            $this->httpClient->setHeaders([
                "content-type", "application/json"
            ]);
            $response = $this->httpClient->post(self::TOKEN_URL, $jsonData);
            $result = json_decode($response);
            return $result['id'];
        } catch (\Exception $e) {
            throw new OpenViduException("Could not retrieve token", OpenViduException::CODE_TOKEN_CANNOT_BE_CREATED, $e);
        }
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
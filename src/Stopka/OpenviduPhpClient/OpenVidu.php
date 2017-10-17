<?php
/**
 * Created by IntelliJ IDEA.
 * User: stopka
 * Date: 13.10.17
 * Time: 12:19
 */

namespace Stopka\OpenviduPhpClient;


use Stopka\OpenviduPhpClient\Http\HttpClient;

class OpenVidu {
    private const HTTP_USERNAME = "OPENVIDUAPP";

    /** @var  string */
    private $urlOpenViduServer;

    /** @var string */
    private $secret;

    private $httpClient;

    /** @var bool */
    private $sslCheck = true;

    /**
     * OpenVidu constructor.
     * @param string $urlOpenViduServer
     * @param string $secret
     */
    public function __construct(string $urlOpenViduServer, string $secret) {
        $this->secret = $secret;
        $this->urlOpenViduServer = $urlOpenViduServer;
        $this->httpClient = $this->buildHttpClient();
    }

    /**
     * @param bool $value
     */
    public function enableSslCheck(bool $value = true): void {
        $this->sslCheck = $value;
    }

    /**
     * @throws OpenViduException
     */
    public function createSession(): Session {
        return new Session($this->httpClient);
    }

    /**
     * @return HttpClient
     */
    private function buildHttpClient(): HttpClient {
        $client = new HttpClient();
        if (!$this->sslCheck) {
            $client->disableSSLHostVerification();
            $client->disableSSLPeerVerification();
        }
        $client->setAuth(CURLAUTH_ANY);
        $client->setUserPassword(self::HTTP_USERNAME, $this->secret);
        $client->setHostUrl($this->urlOpenViduServer);
        return $client;
    }
}
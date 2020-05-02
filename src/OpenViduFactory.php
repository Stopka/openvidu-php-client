<?php

declare(strict_types=1);

namespace Stopka\OpenviduPhpClient;

use GuzzleHttp\ClientInterface;
use Stopka\OpenviduPhpClient\Rest\HttpClientFactory;
use Stopka\OpenviduPhpClient\Rest\RestClient;

class OpenViduFactory
{
    /** @var string */
    private string $urlOpenViduServer;

    /** @var string */
    private string $secret;

    /** @var bool */
    private bool $sslCheck;

    /**
     * OpenViduFactory constructor.
     * @param string $urlOpenViduServer
     * @param string $secret
     * @param bool $sslCheck
     */
    public function __construct(string $urlOpenViduServer, string $secret, bool $sslCheck = true)
    {
        $this->urlOpenViduServer = $urlOpenViduServer;
        $this->secret = $secret;
        $this->sslCheck = $sslCheck;
    }

    /**
     * @return OpenVidu
     */
    public function create(): OpenVidu
    {
        return new OpenVidu($this->createRestClient());
    }

    /**
     * @return RestClient
     */
    private function createRestClient(): RestClient
    {
        return new RestClient($this->createHttpClient());
    }

    /**
     * @return ClientInterface
     */
    private function createHttpClient(): ClientInterface
    {
        return $this->createHttpClientFactory()
            ->create($this->urlOpenViduServer, $this->secret, $this->sslCheck);
    }

    /**
     * @return HttpClientFactory
     */
    private function createHttpClientFactory(): HttpClientFactory
    {
        return new HttpClientFactory();
    }
}

<?php

declare(strict_types=1);

namespace Stopka\OpenviduPhpClient;

use GuzzleHttp\ClientInterface;
use Stopka\OpenviduPhpClient\Rest\HttpClient\ClientConfig;
use Stopka\OpenviduPhpClient\Rest\HttpClient\ClientFactory;
use Stopka\OpenviduPhpClient\Rest\RestClient;

class OpenViduFactory
{
    /**
     * @var string
     */
    private string $urlOpenViduServer;

    /**
     * @var string
     */
    private string $secret;

    /**
     * @var bool
     */
    private bool $sslCheck;

    /**
     * OpenViduFactory constructor.
     *
     * @param string $urlOpenViduServer
     * @param string $secret
     * @param bool   $sslCheck
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
    public function createRestClient(): RestClient
    {
        return new RestClient($this->createHttpClient());
    }

    public function createHttpClientConfig(): ClientConfig
    {
        return new ClientConfig(
            $this->urlOpenViduServer,
            $this->secret,
            $this->sslCheck
        );
    }

    /**
     * @return ClientInterface
     */
    public function createHttpClient(): ClientInterface
    {
        $factory = $this->createHttpClientFactory();
        $config = $this->createHttpClientConfig();

        return $factory->createClient($config);
    }

    /**
     * @return ClientFactory
     */
    public function createHttpClientFactory(): ClientFactory
    {
        return new ClientFactory();
    }
}

<?php

declare(strict_types=1);

namespace Stopka\OpenviduPhpClient\Rest\HttpClient;

use GuzzleHttp\Client;
use GuzzleHttp\ClientInterface;

class ClientFactory
{
    public const AUTH_USER = 'OPENVIDUAPP';
    public const HEADER_ACCEPT = 'Accept';
    public const MIME_JSON = 'application/json';

    public function createClient(ClientConfig $config): ClientInterface
    {
        return new Client($this->buildOptions($config));
    }

    /**
     * @param  ClientConfig $config
     * @return mixed[]
     */
    public function buildOptions(ClientConfig $config): array
    {
        return [
            'base_uri' => $config->getBaseUri(),
            'auth' => [
                self::AUTH_USER,
                $config->getPassword(),
            ],
            'headers' => [
                self::HEADER_ACCEPT => self::MIME_JSON,
            ],
            'verify' => $config->isVerify(),
        ];
    }
}

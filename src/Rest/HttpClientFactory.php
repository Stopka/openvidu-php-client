<?php

declare(strict_types=1);

namespace Stopka\OpenviduPhpClient\Rest;

use GuzzleHttp\Client;
use GuzzleHttp\ClientInterface;

class HttpClientFactory
{
    protected const AUTH_USER = 'OPENVIDUAPP';
    protected const HEADER_ACCEPT = 'Accept';
    protected const MIME_JSON = 'application/json';

    public function create(string $baseUri, string $password, bool $verify = true): ClientInterface
    {
        return new Client(
            [
                'base_uri' => $baseUri,
                'auth' => [
                    self::AUTH_USER,
                    $password,
                ],
                'headers' => [
                    self::HEADER_ACCEPT => self::MIME_JSON,
                ],
                'verify' => $verify,
            ]
        );
    }
}

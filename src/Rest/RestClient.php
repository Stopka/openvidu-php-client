<?php
/**
 * Created by IntelliJ IDEA.
 * User: stopka
 * Date: 22.11.18
 * Time: 16:16
 */

namespace Stopka\OpenviduPhpClient\Rest;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use Psr\Http\Message\ResponseInterface;

class RestClient
{
    /** @var Client */
    private $httpClient;

    const HEADER_ACCEPT = "Accept";
    const MIME_JSON = "application/json";

    /**
     * RestClient constructor.
     * @param string $baseUri
     * @param string $username
     * @param string $password
     */
    public function __construct(string $baseUri, string $username, string $password)
    {
        $this->httpClient = new Client([
            'base_uri' => $baseUri,
            'auth' => [$username, $password],
            'headers' => [
                self::HEADER_ACCEPT => self::MIME_JSON
            ]
        ]);
    }

    /**
     * @param array $data
     * @return array
     */
    private function prepareOptions(array $data = []): array
    {
        return [
            'json' => $data
        ];
    }

    /**
     * @param string $url
     * @param array $data
     * @return RestResponse
     * @throws RestResponseException
     */
    public function post(string $url, array $data = []): RestResponse
    {
        $options = $this->prepareOptions($data);
        return $this->processResponse(function () use ($url, $options): ResponseInterface {
            return $this->httpClient->post($url, $options);
        });
    }

    /**
     * @param string $url
     * @return RestResponse
     * @throws RestResponseException
     */
    public function get(string $url): RestResponse
    {
        return $this->processResponse(function () use ($url): ResponseInterface {
            return $this->httpClient->get($url);
        });
    }

    /**
     * @param string $url
     * @return RestResponse
     * @throws RestResponseException
     */
    public function delete(string $url): RestResponse
    {
        return $this->processResponse(function () use ($url): ResponseInterface {
            return $this->httpClient->delete($url);
        });
    }

    /**
     * @param callable $callback
     * @return RestResponse
     * @throws RestResponseException
     */
    private function processResponse(callable $callback): RestResponse
    {
        try {
            $response = call_user_func($callback);
        } catch (RequestException $e) {
            throw new RestResponseException($e);
        }
        return new RestResponse($response);
    }

}

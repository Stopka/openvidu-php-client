<?php

declare(strict_types=1);

namespace Stopka\OpenviduPhpClient\Rest;

use GuzzleHttp\ClientInterface;
use GuzzleHttp\Exception\RequestException;
use Psr\Http\Message\ResponseInterface;

class RestClient
{

    /** @var ClientInterface */
    private ClientInterface $httpClient;


    /**
     * RestClient constructor.
     * @param ClientInterface $httpClient
     */
    public function __construct(ClientInterface $httpClient)
    {
        $this->httpClient = $httpClient;
    }

    /**
     * @param string $url
     * @param mixed[] $data
     * @return RestResponse
     * @throws RestResponseException
     */
    public function post(string $url, array $data = []): RestResponse
    {
        $options = $this->prepareOptions($data);

        return $this->processResponse(
            fn(): ResponseInterface => $this->httpClient->request(HttpMethodEnum::POST, $url, $options)
        );
    }

    /**
     * @param string $url
     * @param mixed[] $data
     * @return RestResponse
     */
    public function put(string $url, array $data = []): RestResponse
    {
        $options = $this->prepareOptions($data);

        return $this->processResponse(
            fn(): ResponseInterface => $this->httpClient->request(HttpMethodEnum::PUT, $url, $options)
        );
    }

    /**
     * @param string $url
     * @return RestResponse
     * @throws RestResponseException
     */
    public function get(string $url): RestResponse
    {
        return $this->processResponse(
            fn(): ResponseInterface => $this->httpClient->request(HttpMethodEnum::GET, $url)
        );
    }

    /**
     * @param string $url
     * @return RestResponse
     * @throws RestResponseException
     */
    public function delete(string $url): RestResponse
    {
        return $this->processResponse(
            fn(): ResponseInterface => $this->httpClient->request(HttpMethodEnum::DELETE, $url)
        );
    }

    /**
     * @param mixed[] $data
     * @return mixed[]
     */
    private function prepareOptions(array $data = []): array
    {
        return [
            'json' => $data,
        ];
    }

    /**
     * @param callable $callback
     * @return RestResponse
     * @throws RestResponseException
     */
    private function processResponse(callable $callback): RestResponse
    {
        try {
            $response = $callback();
        } catch (RequestException $e) {
            throw new RestResponseException($e);
        }

        return new RestResponse($response);
    }
}

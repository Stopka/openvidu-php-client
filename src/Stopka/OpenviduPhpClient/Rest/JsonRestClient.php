<?php
/**
 * Created by IntelliJ IDEA.
 * User: stopka
 * Date: 13.10.17
 * Time: 14:42
 */

namespace Stopka\OpenviduPhpClient\Rest;


use Stopka\OpenviduPhpClient\Http\HttpClient;
use Stopka\OpenviduPhpClient\Http\HttpClientException;
use Stopka\OpenviduPhpClient\Http\HttpResponse;

class JsonRestClient {

    /** @var  string */
    private $hostUrl;

    /** @var HttpClient */
    private $httpClient;

    public function __construct(HttpClient $httpClient, string $hostUrl = "") {
        $this->httpClient = $httpClient;
        $this->hostUrl = $hostUrl;
    }

    protected function getPreparedClient(): HttpClient {
        $httpClient = $this->getHttpClient();
        $httpClient->setHeaders([
            "Content-Type: application/json"
        ]);
        return $httpClient;
    }

    /**
     * @param string $url
     * @param array $params
     * @return array
     * @throws RestClientException
     */
    public function post(string $url, array $params = []): array {
        return $this->doRequest($url, function (HttpClient $client, string $url) use ($params) {
            return $client->post($url, json_encode($params));
        });
    }

    /**
     * @param string $url
     * @param array $params
     * @return array
     * @throws RestClientException
     */
    public function get(string $url): array {
        return $this->doRequest($url, function (HttpClient $client, string $url) {
            return $client->get($this->getFullUrl($url));
        });
    }

    /**
     * @param string $url
     * @return array
     * @throws RestClientException
     */
    public function delete(string $url): array {
        return $this->doRequest($url, function (HttpClient $client, string $url) {
            return $client->delete($url);
        });
    }

    /**
     * @param string $url
     * @param callable $callable
     * @return array
     * @throws RestClientException
     */
    private function doRequest(string $url, callable $callable): array {
        try {
            $result = call_user_func($callable, $this->getPreparedClient(), $this->getFullUrl($url));
        } catch (HttpClientException $e) {
            throw new RestClientException("Http request failed", 0, $e);
        }
        return $this->parseResponse($result);
    }

    /**
     * @param HttpResponse $response
     * @return array
     * @throws RestClientException
     */
    private function parseResponse(HttpResponse $response): array {
        if ($response->getStatus() !== 200) {
            $result = json_decode($response->getContent(), true);
            if ($result && is_array($result) && isset($result['message'])) {
                throw new RestClientException($result['message'], $response->getStatus());
            }
            throw new RestClientException("Invalid response status code " . $response->getStatus(), $response->getStatus());
        }
        $content = $response->getContent();
        if (!$content) {
            return [];
        }
        $result = json_decode($response->getContent(), true);
        if (!is_array($result)) {
            throw new RestClientException("Unable to parse response content");
        }
        return $result;
    }

    /**
     * @param string $url
     * @return string
     */
    protected function getFullUrl(string $url): string {
        if (!$this->hostUrl) {
            return $url;
        }
        if (substr($url, 0, 1) == "/") {
            $url = substr($url, 1);
        }
        return $this->hostUrl . $url;
    }

    /**
     * @param string $hostUrl
     */
    public function setHostUrl(string $hostUrl): void {
        $this->hostUrl = $hostUrl;
        if (substr($this->hostUrl, -1) !== "/") {
            $this->hostUrl .= "/";
        }
    }

    /**
     * @return HttpClient
     */
    public function getHttpClient(): HttpClient {
        return $this->httpClient;
    }

    /**
     * @param HttpClient $httpClient
     */
    public function setHttpClient(HttpClient $httpClient): void {
        $this->httpClient = $httpClient;
    }

}
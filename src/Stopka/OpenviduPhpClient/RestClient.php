<?php
/**
 * Created by IntelliJ IDEA.
 * User: stopka
 * Date: 22.11.18
 * Time: 16:16
 */

namespace Stopka\OpenviduPhpClient;


use GuzzleHttp\Client;
use Psr\Http\Message\ResponseInterface;

class RestClient {
    /** @var Client */
    private $httpClient;

    const HEADER_ACCEPT = "Accept";
    const HEADER_CONTENT_TYPE = "Content-Type";
    const MIME_JSON = "application/json";

    public function __construct(string $baseUri, string $username, string $password) {
        $this->httpClient = new Client([
            'base_uri' => $baseUri,
            'auth' => [$username, $password],
            'headers' => [
                self::HEADER_ACCEPT => self::MIME_JSON
            ]
        ]);
    }

    private function prepareOptions(array $data = []): array {
        return [
            'json' => $data
        ];
    }

    public function post(string $url, array $data = []): array {
        $response = $this->httpClient->post($url, $this->prepareOptions($data));
        return $this->processResponse($response);
    }

    private function processResponse(ResponseInterface $response): array {
        $contentType = $response->getHeader(self::HEADER_CONTENT_TYPE);
        $result = null;
        if ($contentType == self::MIME_JSON) {
            $result = json_decode($response->getBody(), true);
        }
        if ($response->getStatusCode() !== 200) {
            if($result && isset($result['message'])){
                throw new RestClientException($result['message'],$response->getStatusCode());
            }
            throw new RestClientException($response->getStatusCode()." ".$response->getReasonPhrase(),$response->getStatusCode());
        }
        if(!$result){
            return [];
        }
    }

}
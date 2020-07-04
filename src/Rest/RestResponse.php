<?php

declare(strict_types=1);

namespace Stopka\OpenviduPhpClient\Rest;

use JsonException;
use Psr\Http\Message\ResponseInterface;

class RestResponse
{
    protected const HEADER_CONTENT_TYPE = 'Content-Type';
    protected const MIME_JSON = 'application/json';

    /**
     * @var ResponseInterface
     */
    private ResponseInterface $httpResponse;

    public function __construct(ResponseInterface $response)
    {
        $this->httpResponse = $response;
    }

    /**
     * @return mixed[]
     * @throws RestResponseInvalidException
     */
    public function getArray(): array
    {
        $data = $this->parseData();
        if (!is_array($data)) {
            throw new RestResponseInvalidException('Expected array data');
        }

        return $data;
    }

    /**
     * @param  string $key
     * @return mixed
     * @throws RestResponseInvalidException
     */
    public function getDataInArrayKey(string $key)
    {
        $result = $this->getArray();
        if (!array_key_exists($key, $result)) {
            throw new RestResponseInvalidException("Missing key '$key' in response data");
        }

        return $result[$key];
    }

    /**
     * @param  string $key
     * @return string
     * @throws RestResponseInvalidException
     */
    public function getStringInArrayKey(string $key): string
    {
        $result = $this->getDataInArrayKey($key);
        if (!is_string($result)) {
            throw new RestResponseInvalidException("Key '$key' does not contain string");
        }

        return $result;
    }

    /**
     * @param  string $key
     * @return mixed[]
     * @throws RestResponseInvalidException
     */
    public function getArrayInArrayKey(string $key): array
    {
        $result = $this->getDataInArrayKey($key);
        if (!is_array($result)) {
            throw new RestResponseInvalidException("Key '$key' does not contain array");
        }

        return $result;
    }

    /**
     * @return mixed
     */
    private function parseData()
    {
        $this->checkContentType();
        try {
            $this->httpResponse->getBody()->rewind();

            return json_decode($this->httpResponse->getBody()->getContents(), true, 512, JSON_THROW_ON_ERROR);
        } catch (JsonException $e) {
            throw new RestResponseInvalidException('Could not parse json', 0, $e);
        }
    }

    /**
     * @throws RestResponseInvalidException
     */
    private function checkContentType(): void
    {
        $contentType = $this->httpResponse->getHeader(self::HEADER_CONTENT_TYPE);
        if (!in_array(self::MIME_JSON, $contentType, true)) {
            throw new RestResponseInvalidException('Invalid content type ' . implode(',', $contentType));
        }
    }
}

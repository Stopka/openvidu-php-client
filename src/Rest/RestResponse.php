<?php


namespace Stopka\OpenviduPhpClient\Rest;


use Psr\Http\Message\ResponseInterface;

class RestResponse
{
    const HEADER_CONTENT_TYPE = "Content-Type";
    const MIME_JSON = "application/json";

    /** @var ResponseInterface */
    private $response;

    public function __construct(ResponseInterface $response)
    {
        $this->response = $response;
    }

    /**
     * @throws RestResponseInvalidException
     */
    private function checkContentType()
    {
        $contentType = $this->response->getHeader(self::HEADER_CONTENT_TYPE);
        if (!in_array(self::MIME_JSON, $contentType)) {
            throw new RestResponseInvalidException("Invalid content type ".implode(',',$contentType));
        }
    }

    /**
     * @return array
     * @throws RestResponseInvalidException
     */
    public function getArray(): array
    {
        $this->checkContentType();
        $array = json_decode($this->response->getBody(), true);
        if (!is_array($array)) {
            throw new RestResponseInvalidException('Could not parse json');
        }
        return $array;
    }

    /**
     * @param string $key
     * @return mixed
     */
    public function getDataInArrayKey(string $key)
    {
        $result = $this->getArray();
        if (!isset($result[$key])) {
            throw new RestResponseInvalidException("Missing key '$key' in response data");
        }
        return $result[$key];
    }

    /**
     * @param string $key
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
     * @param string $key
     * @return array
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
}

<?php


namespace Stopka\OpenviduPhpClient\Rest;


use GuzzleHttp\Exception\RequestException;

class RestResponseException extends RestClientException
{
    /** @var RestResponse */
    private $response;

    public function __construct(RequestException $previous)
    {
        if ($previous->hasResponse()) {
            $this->response = new RestResponse($previous->getResponse());
            try {
                $message = $this->response->getStringInArrayKey('message');
            } catch (RestResponseInvalidException $e) {

            }
        }
        $message = $message ?? $previous->getMessage();
        parent::__construct($message, $previous->getCode(), $previous);
    }

    public function getResponse(): RestResponse
    {
        return $this->response;
    }


}

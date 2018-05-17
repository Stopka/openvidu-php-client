<?php
/**
 * Created by IntelliJ IDEA.
 * User: stopka
 * Date: 13.10.17
 * Time: 14:42
 */

namespace Stopka\OpenviduPhpClient\Http;


class HttpClient {
    private const METHOD_POST = "POST";
    private const METHOD_DELETE = "DELETE";
    private const METHOD_GET = "GET";

    /** @var array */
    private $options = [];

    /** @var array */
    private $oneTimeOptions = [];

    /**
     * @param int $option
     * @param callable|mixed $value
     * @param bool $oneTime
     */
    private function setOption(int $option, $value, bool $oneTime = false) {
        if ($oneTime) {
            $this->oneTimeOptions[$option] = $value;
            return;
        }
        $this->options[$option] = $value;
    }

    /**
     * @param bool $value
     */
    public function disableSSLPeerVerification(bool $value = true): void {
        $this->setOption(CURLOPT_SSL_VERIFYPEER, !$value);
    }

    /**
     * @param bool $value
     */
    public function disableSSLHostVerification(bool $value = true): void {
        $this->setOption(CURLOPT_SSL_VERIFYHOST, !$value);
    }

    /**
     * @param int $auth
     */
    public function setAuth(int $auth): void {
        $this->setOption(CURLOPT_HTTPAUTH, $auth);
    }

    /**
     * @param string $username
     * @param string $password
     */
    public function setUserPassword(string $username, string $password): void {
        $this->setOption(CURLOPT_USERPWD, "$username:$password");
    }

    /**
     * @param array $values
     */
    public function setHeaders(array $values): void {
        $this->setOption(CURLOPT_HTTPHEADER, $values);
    }

    /**
     * @param bool $result
     * @param resource $ch
     * @throws HttpClientException
     */
    private function throwExceptionIfError(bool $result, $ch): void {
        if (!$result) {
            throw new HttpClientException(curl_error($ch), curl_errno($ch));
        }
    }

    /**
     * @param resource $ch
     * @throws HttpClientException
     */
    private function applyOptions($ch): void {
        $result = curl_setopt_array($ch, $this->options);
        $this->throwExceptionIfError($result, $ch);
        $result = curl_setopt_array($ch, $this->oneTimeOptions);
        $this->throwExceptionIfError($result, $ch);
        $this->oneTimeOptions = [];
    }

    /**
     * @param string $url
     * @param string $method
     * @param null $data
     * @return HttpResponse
     * @throws HttpClientException
     */
    private function execute(string $url, string $method = self::METHOD_GET, $data = null): HttpResponse {
        $ch = curl_init($url);
        $this->applyOptions($ch);
        $result = curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);
        $this->throwExceptionIfError($result, $ch);
        $result = curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $this->throwExceptionIfError($result, $ch);
        if ($data) {
            $result = curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
            $this->throwExceptionIfError($result, $ch);
        }
        $output = curl_exec($ch);
        $status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $this->throwExceptionIfError($output, $ch);
        curl_close($ch);
        return new HttpResponse($status, $output);
    }

    /**
     * @param string $url
     * @param null $data
     * @return HttpResponse
     * @throws HttpClientException
     */
    public function post(string $url, $data = null): HttpResponse {
        return $this->execute($url, self::METHOD_POST, $data);
    }

    /**
     * @param string $url
     * @return HttpResponse
     * @throws HttpClientException
     */
    public function get(string $url): HttpResponse {
        return $this->execute($url);
    }

    /**
     * @param string $url
     * @return HttpResponse
     * @throws HttpClientException
     */
    public function delete(string $url): HttpResponse {
        return $this->execute($url, self::METHOD_DELETE);
    }
}
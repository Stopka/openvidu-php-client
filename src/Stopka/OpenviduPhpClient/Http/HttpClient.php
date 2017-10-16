<?php
/**
 * Created by IntelliJ IDEA.
 * User: stopka
 * Date: 13.10.17
 * Time: 14:42
 */

namespace Stopka\OpenviduPhpClient\Http;


class HttpClient {
    /** @var  resource */
    private $resource;

    /** @var  string */
    private $hostUrl;

    public function __construct() {
        $this->resource = curl_init();
    }

    /**
     * @param bool $value
     * @throws HttpClientException
     */
    public function disableSSLPeerVerification(bool $value = true): void {
        $result = curl_setopt($this->resource, CURLOPT_SSL_VERIFYPEER, !$value);
        $this->throwExceptionIfError($result);
    }

    /**
     * @param bool $value
     * @throws HttpClientException
     */
    public function disableSSLHostVerification(bool $value = true): void {
        $result = curl_setopt($this->resource, CURLOPT_SSL_VERIFYHOST, !$value);
        $this->throwExceptionIfError($result);
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

    public function setAuth(int $auth): void {
        $result = curl_setopt($this->resource, CURLOPT_HTTPAUTH, $auth);
        $this->throwExceptionIfError($result);
    }

    /**
     * @param string $username
     * @param string $password
     * @throws HttpClientException
     */
    public function setUserPassword(string $username, string $password): void {
        $result = curl_setopt($this->resource, CURLOPT_USERPWD, "$username:$password");
        $this->throwExceptionIfError($result);
    }

    /**
     * @param bool $result
     * @throws HttpClientException
     */
    private function throwExceptionIfError(bool $result): void {
        if (!$result) {
            throw new HttpClientException(curl_error($this->resource), curl_errno($this->resource));
        }
    }

    public function post(string $url, ?array $data = null): string {
        $result = curl_setopt($this->resource, CURLOPT_URL, $this->getFullUrl($url));
        $this->throwExceptionIfError($result);
        $result = curl_setopt($this->resource, CURLOPT_RETURNTRANSFER, true);
        $this->throwExceptionIfError($result);
        $result = curl_setopt($this->resource, CURLOPT_POST, true);
        $this->throwExceptionIfError($result);
        if ($data) {
            $result = curl_setopt($this->resource, CURLOPT_POSTFIELDS, $data);
            $this->throwExceptionIfError($result);
        }
        $output = curl_exec($this->resource);
        $this->throwExceptionIfError($output);
        return $output;
    }

    public function __destruct() {
        curl_close($this->resource);
    }

    /**
     * @param array $values
     */
    public function setHeaders(array $values): void {
        //TODO check if replaces settings
        $result = curl_setopt($this->resource, CURLOPT_HTTPHEADER, $values);
        $this->throwExceptionIfError($result);
    }
}
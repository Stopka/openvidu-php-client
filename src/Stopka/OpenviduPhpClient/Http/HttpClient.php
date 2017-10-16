<?php
/**
 * Created by IntelliJ IDEA.
 * User: stopka
 * Date: 13.10.17
 * Time: 14:42
 */

namespace Stopka\OpenviduPhpClient\Http;


class HttpClient {

    /** @var  string */
    private $hostUrl;

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
    private function throwExceptionIfError(bool $result, resource $ch): void {
        if (!$result) {
            throw new HttpClientException(curl_error($ch), curl_errno($ch));
        }
    }

    /**
     * @param resource $ch
     * @throws HttpClientException
     */
    private function applyOptions(resource $ch): void {
        $result = curl_setopt_array($ch, $this->options);
        $this->throwExceptionIfError($result,$ch);
        $result = curl_setopt_array($ch, $this->oneTimeOptions);
        $this->throwExceptionIfError($result,$ch);
        $this->oneTimeOptions = [];
    }

    public function post(string $url, ?array $data = null): HttpResponse {
        $ch = curl_init($this->getFullUrl($url));
        $this->applyOptions($ch);
        $result = curl_setopt($ch, CURLOPT_URL, $this->getFullUrl($url));
        $this->throwExceptionIfError($result,$ch);
        $result = curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $this->throwExceptionIfError($result,$ch);
        $result = curl_setopt($ch, CURLOPT_POST, true);
        $this->throwExceptionIfError($result,$ch);
        if ($data) {
            $result = curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
            $this->throwExceptionIfError($result,$ch);
        }
        $output = curl_exec($ch);
        $status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $this->throwExceptionIfError($output,$ch);
        curl_close($ch);
        return new HttpResponse($status, $output);
    }
}
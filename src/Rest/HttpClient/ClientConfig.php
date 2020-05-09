<?php

namespace Stopka\OpenviduPhpClient\Rest\HttpClient;

class ClientConfig
{
    /** @var string */
    private string $baseUri;

    /** @var string */
    private string $password;

    /** @var bool */
    private bool $verify;

    /**
     * HttpClientConfig constructor.
     *
     * @param string $baseUri
     * @param string $password
     * @param bool   $verify
     */
    public function __construct(string $baseUri, string $password, bool $verify = true)
    {
        $this->baseUri = $baseUri;
        $this->password = $password;
        $this->verify = $verify;
    }

    /**
     * @return string
     */
    public function getBaseUri(): string
    {
        return $this->baseUri;
    }

    /**
     * @return string
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    /**
     * @return bool
     */
    public function isVerify(): bool
    {
        return $this->verify;
    }
}

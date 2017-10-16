<?php
/**
 * Created by IntelliJ IDEA.
 * User: stopka
 * Date: 13.10.17
 * Time: 14:42
 */

namespace Stopka\OpenviduPhpClient\Http;


class HttpResponse {
    /** @var  int $status */
    private $status;
    /** @var  string|null $content */
    private $content;

    /**
     * HttpClientException constructor.
     * @param int $status
     * @param null|string $content
     */
    public function __construct(int $status, ?string $content = null) {
        $this->status = $status;
        $this->content = $content;
    }

    /**
     * @return int
     */
    public function getStatus(): int {
        return $this->status;
    }

    /**
     * @return null|string
     */
    public function getContent(): ?string {
        return $this->content;
    }

}
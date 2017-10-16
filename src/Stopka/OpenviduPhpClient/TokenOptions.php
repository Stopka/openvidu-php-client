<?php
/**
 * Created by IntelliJ IDEA.
 * User: stopka
 * Date: 13.10.17
 * Time: 14:01
 */

namespace Stopka\OpenviduPhpClient;


class TokenOptions {
    /** @var  string */
    private $data;
    /** @var  string */
    private $role;

    /**
     * TokenOptions constructor.
     * @param string $data
     * @param string $role
     */
    public function __construct(string $data, string $role) {
        $this->data = $data;
        $this->role = $role;
    }

    /**
     * @return string
     */
    public function getData(): string {
        return $this->data;
    }

    /**
     * @return string
     */
    public function getRole(): string {
        return $this->role;
    }

}
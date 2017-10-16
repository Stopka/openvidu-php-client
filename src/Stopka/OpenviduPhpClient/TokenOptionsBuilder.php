<?php
/**
 * Created by IntelliJ IDEA.
 * User: stopka
 * Date: 13.10.17
 * Time: 14:01
 */

namespace Stopka\OpenviduPhpClient\TokenOptions;


use Stopka\OpenviduPhpClient\OpenViduRole;
use Stopka\OpenviduPhpClient\TokenOptions;

class TokenOptionsBuilder {
    /** @var  string */
    private $data = "";
    /** @var  string */
    private $role = OpenViduRole::PUBLISHER;

    /**
     * @return string
     */
    public function getData(): string {
        return $this->data;
    }

    /**
     * @param string $data
     * @return self
     */
    public function setData(string $data): self {
        $this->data = $data;
        return $this;
    }

    /**
     * @return string
     */
    public function getRole(): string {
        return $this->role;
    }

    /**
     * @param string $role
     * @return self
     */
    public function setRole(string $role): self {
        $this->role = $role;
        return $this;
    }

    /**
     * @return TokenOptions
     */
    public function build(): TokenOptions{
        return new TokenOptions($this->data,$this->role);
    }

}
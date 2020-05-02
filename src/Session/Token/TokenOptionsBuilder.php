<?php
/**
 * Created by IntelliJ IDEA.
 * User: stopka
 * Date: 13.10.17
 * Time: 14:01
 */

namespace Stopka\OpenviduPhpClient\Session\Token;


use Stopka\OpenviduPhpClient\OpenViduRoleEnum;

class TokenOptionsBuilder
{

    /** @var  string */
    private $data = "";

    /** @var  OpenViduRoleEnum */
    private $role;

    /** @var KurentoOptions */
    private $kurentoOptions;


    public function __construct()
    {
        $this->role = new OpenViduRoleEnum(OpenViduRoleEnum::PUBLISHER);
    }

    /**
     * @param string $data
     * @return self
     */
    public function setData(string $data): self
    {
        $this->data = $data;
        return $this;
    }

    /**
     * @param OpenViduRoleEnum $role
     * @return self
     */
    public function setRole(OpenViduRoleEnum $role): self
    {
        $this->role = $role;
        return $this;
    }

    /**
     * @param KurentoOptions $kurentoOptions
     * @return self
     */
    public function setKurentoOptions(KurentoOptions $kurentoOptions): self
    {
        $this->kurentoOptions = $kurentoOptions;
        return $this;
    }

    /**
     * @return TokenOptions
     */
    public function build(): TokenOptions
    {
        return new TokenOptions($this->data, $this->role, $this->kurentoOptions);
    }

}

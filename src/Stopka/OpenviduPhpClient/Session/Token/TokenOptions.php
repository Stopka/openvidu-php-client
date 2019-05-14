<?php
/**
 * Created by IntelliJ IDEA.
 * User: stopka
 * Date: 13.10.17
 * Time: 14:01
 */

namespace Stopka\OpenviduPhpClient\Session\Token;


use Stopka\OpenviduPhpClient\OpenViduRoleEnum;

class TokenOptions
{

    /** @var  string */
    private $data;

    /** @var  OpenViduRoleEnum */
    private $role;

    /** @var KurentoOptions */
    private $kurentoOptions;

    /**
     * TokenOptions constructor.
     * @param string $data
     * @param OpenViduRoleEnum $role
     * @param KurentoOptions|null $kurentoOptions
     */
    public function __construct(string $data, OpenViduRoleEnum $role, ?KurentoOptions $kurentoOptions = null)
    {
        $this->data = $data;
        $this->role = $role;
        $this->kurentoOptions = $kurentoOptions;
    }

    /**
     * @return string
     */
    public function getData(): string
    {
        return $this->data;
    }

    /**
     * @return OpenViduRoleEnum
     */
    public function getRole(): OpenViduRoleEnum
    {
        return $this->role;
    }

    /**
     * @return KurentoOptions|null
     */
    public function getKurentoOptions(): ?KurentoOptions
    {
        return $this->kurentoOptions;
    }
}

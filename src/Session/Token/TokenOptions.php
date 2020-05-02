<?php

declare(strict_types=1);

namespace Stopka\OpenviduPhpClient\Session\Token;

use Stopka\OpenviduPhpClient\OpenViduRoleEnum;

class TokenOptions
{

    /** @var  string */
    private string $data;

    /** @var  OpenViduRoleEnum */
    private OpenViduRoleEnum $role;

    /** @var KurentoOptions */
    private ?KurentoOptions $kurentoOptions;

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

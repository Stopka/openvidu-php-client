<?php


namespace Stopka\OpenviduPhpClient\Session\Token;


class KurentoOptions
{
    /** @var int|null */
    private $videoMaxRecvBandwidth;

    /** @var int|null */
    private $videoMinRecvBandwidth;

    /** @var int|null */
    private $videoMaxSendBandwidth;

    /** @var int|null */
    private $videoMinSendBandwidth;

    /** @var string[] */
    private $allowedFilters;

    public function __construct(
        ?int $videoMaxRecvBandwidth,
        ?int $videoMinRecvBandwidth,
        ?int $videoMaxSendBandwidth,
        ?int $videoMinSendBandwidth,
        array $allowedFilters
    ) {
        $this->videoMaxRecvBandwidth = $videoMaxRecvBandwidth;
        $this->videoMinRecvBandwidth = $videoMinRecvBandwidth;
        $this->videoMaxSendBandwidth = $videoMaxSendBandwidth;
        $this->videoMinSendBandwidth = $videoMinSendBandwidth;
        $this->allowedFilters = $allowedFilters;
    }


    /**
     * @return int
     */
    public function getVideoMaxRecvBandwidth(): ?int
    {
        return $this->videoMaxRecvBandwidth;
    }

    /**
     * @return int
     */
    public function getVideoMinRecvBandwidth(): ?int
    {
        return $this->videoMinRecvBandwidth;
    }

    /**
     * @return int
     */
    public function getVideoMaxSendBandwidth(): ?int
    {
        return $this->videoMaxSendBandwidth;
    }

    /**
     * @return int
     */
    public function getVideoMinSendBandwidth(): ?int
    {
        return $this->videoMinSendBandwidth;
    }

    /**
     * @return string[]
     */
    public function getAllowedFilters(): array
    {
        return clone $this->allowedFilters;
    }

    public function getDataArray(): array
    {
        $result = [];
        if ($this->videoMaxRecvBandwidth) {
            $result['videoMaxRecvBandwidth'] = $this->videoMaxRecvBandwidth;
        }
        if ($this->videoMinRecvBandwidth) {
            $result['videoMinRecvBandwidth'] = $this->videoMinRecvBandwidth;
        }
        if ($this->videoMaxSendBandwidth) {
            $result['videoMaxSendBandwidth'] = $this->videoMaxSendBandwidth;
        }
        if ($this->videoMinSendBandwidth) {
            $result['videoMinSendBandwidth'] = $this->videoMinSendBandwidth;
        }
        $result['allowedFilters'] = clone $this->allowedFilters;
        return $result;
    }
}

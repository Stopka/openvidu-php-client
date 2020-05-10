<?php

declare(strict_types=1);

namespace Stopka\OpenviduPhpClient\Session\Token;

class KurentoOptionsBuilder
{
    public const BANDWIDTH_UNCONSTRAINED = 0;

    /** @var int */
    private int $videoMaxRecvBandwidth = self::BANDWIDTH_UNCONSTRAINED;

    /** @var int */
    private int $videoMinRecvBandwidth = self::BANDWIDTH_UNCONSTRAINED;

    /** @var int */
    private int $videoMaxSendBandwidth = self::BANDWIDTH_UNCONSTRAINED;

    /** @var int */
    private int $videoMinSendBandwidth = self::BANDWIDTH_UNCONSTRAINED;

    /** @var string[] */
    private array $allowedFilters = [];

    /**
     * @param int $videoMaxRecvBandwidth
     * @return self
     */
    public function setVideoMaxRecvBandwidth(int $videoMaxRecvBandwidth = self::BANDWIDTH_UNCONSTRAINED): self
    {
        $this->videoMaxRecvBandwidth = $videoMaxRecvBandwidth;

        return $this;
    }

    /**
     * @param int $videoMinRecvBandwidth
     * @return self
     */
    public function setVideoMinRecvBandwidth(int $videoMinRecvBandwidth = self::BANDWIDTH_UNCONSTRAINED): self
    {
        $this->videoMinRecvBandwidth = $videoMinRecvBandwidth;

        return $this;
    }

    /**
     * @param int $videoMaxSendBandwidth
     * @return self
     */
    public function setVideoMaxSendBandwidth(int $videoMaxSendBandwidth = self::BANDWIDTH_UNCONSTRAINED): self
    {
        $this->videoMaxSendBandwidth = $videoMaxSendBandwidth;

        return $this;
    }

    /**
     * @param int $videoMinSendBandwidth
     * @return self
     */
    public function setVideoMinSendBandwidth(int $videoMinSendBandwidth = self::BANDWIDTH_UNCONSTRAINED): self
    {
        $this->videoMinSendBandwidth = $videoMinSendBandwidth;

        return $this;
    }

    /**
     * @param string[] $allowedFilters
     * @return self
     */
    public function setAllowedFilters(array $allowedFilters = []): self
    {
        $this->allowedFilters = $allowedFilters;

        return $this;
    }

    public function build(): KurentoOptions
    {
        return new KurentoOptions(
            $this->videoMaxRecvBandwidth,
            $this->videoMinRecvBandwidth,
            $this->videoMaxSendBandwidth,
            $this->videoMinSendBandwidth,
            $this->allowedFilters
        );
    }
}

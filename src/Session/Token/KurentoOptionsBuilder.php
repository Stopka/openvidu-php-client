<?php

declare(strict_types=1);

namespace Stopka\OpenviduPhpClient\Session\Token;

class KurentoOptionsBuilder
{
    /** @var int|null */
    private ?int $videoMaxRecvBandwidth;

    /** @var int|null */
    private ?int $videoMinRecvBandwidth;

    /** @var int|null */
    private ?int $videoMaxSendBandwidth;

    /** @var int|null */
    private ?int $videoMinSendBandwidth;

    /** @var string[] */
    private array $allowedFilters = [];

    /**
     * @param int|null $videoMaxRecvBandwidth
     * @return self
     */
    public function setVideoMaxRecvBandwidth(?int $videoMaxRecvBandwidth): self
    {
        $this->videoMaxRecvBandwidth = $videoMaxRecvBandwidth;

        return $this;
    }

    /**
     * @param int|null $videoMinRecvBandwidth
     * @return self
     */
    public function setVideoMinRecvBandwidth(?int $videoMinRecvBandwidth): self
    {
        $this->videoMinRecvBandwidth = $videoMinRecvBandwidth;

        return $this;
    }

    /**
     * @param int|null $videoMaxSendBandwidth
     * @return self
     */
    public function setVideoMaxSendBandwidth(?int $videoMaxSendBandwidth): self
    {
        $this->videoMaxSendBandwidth = $videoMaxSendBandwidth;

        return $this;
    }

    /**
     * @param int|null $videoMinSendBandwidth
     * @return self
     */
    public function setVideoMinSendBandwidth(?int $videoMinSendBandwidth): self
    {
        $this->videoMinSendBandwidth = $videoMinSendBandwidth;

        return $this;
    }

    /**
     * @param string[] $allowedFilters
     * @return self
     */
    public function setAllowedFilters(array $allowedFilters): self
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

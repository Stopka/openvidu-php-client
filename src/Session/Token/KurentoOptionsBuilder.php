<?php


namespace Stopka\OpenviduPhpClient\Session\Token;


class KurentoOptionsBuilder
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
    private $allowedFilters = [];

    /**
     * @param int $videoMaxRecvBandwidth
     * @return static
     */
    public function setVideoMaxRecvBandwidth(?int $videoMaxRecvBandwidth): self
    {
        $this->videoMaxRecvBandwidth = $videoMaxRecvBandwidth;
        return $this;
    }

    /**
     * @param int $videoMinRecvBandwidth
     * @return static
     */
    public function setVideoMinRecvBandwidth(?int $videoMinRecvBandwidth): self
    {
        $this->videoMinRecvBandwidth = $videoMinRecvBandwidth;
        return $this;
    }

    /**
     * @param int $videoMaxSendBandwidth
     * @return static
     */
    public function setVideoMaxSendBandwidth(?int $videoMaxSendBandwidth): self
    {
        $this->videoMaxSendBandwidth = $videoMaxSendBandwidth;
        return $this;
    }

    /**
     * @param int $videoMinSendBandwidth
     * @return static
     */
    public function setVideoMinSendBandwidth(?int $videoMinSendBandwidth): self
    {
        $this->videoMinSendBandwidth = $videoMinSendBandwidth;
        return $this;
    }

    /**
     * @param string[] $allowedFilters
     * @return static
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

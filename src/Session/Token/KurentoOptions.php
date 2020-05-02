<?php

declare(strict_types=1);

namespace Stopka\OpenviduPhpClient\Session\Token;

class KurentoOptions
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
    private array $allowedFilters;

    /**
     * KurentoOptions constructor.
     * @param int|null $videoMaxRecvBandwidth
     * @param int|null $videoMinRecvBandwidth
     * @param int|null $videoMaxSendBandwidth
     * @param int|null $videoMinSendBandwidth
     * @param string[] $allowedFilters
     */
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
     * @return int|null
     */
    public function getVideoMaxRecvBandwidth(): ?int
    {
        return $this->videoMaxRecvBandwidth;
    }

    /**
     * @return int|null
     */
    public function getVideoMinRecvBandwidth(): ?int
    {
        return $this->videoMinRecvBandwidth;
    }

    /**
     * @return int|null
     */
    public function getVideoMaxSendBandwidth(): ?int
    {
        return $this->videoMaxSendBandwidth;
    }

    /**
     * @return int|null
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
        return $this->allowedFilters;
    }

    /**
     * @return mixed[]
     */
    public function getDataArray(): array
    {
        $result = [];
        if (null !== $this->videoMaxRecvBandwidth) {
            $result['videoMaxRecvBandwidth'] = $this->videoMaxRecvBandwidth;
        }
        if (null !== $this->videoMinRecvBandwidth) {
            $result['videoMinRecvBandwidth'] = $this->videoMinRecvBandwidth;
        }
        if (null !== $this->videoMaxSendBandwidth) {
            $result['videoMaxSendBandwidth'] = $this->videoMaxSendBandwidth;
        }
        if (null !== $this->videoMinSendBandwidth) {
            $result['videoMinSendBandwidth'] = $this->videoMinSendBandwidth;
        }
        $result['allowedFilters'] = $this->allowedFilters;

        return $result;
    }
}

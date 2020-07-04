<?php

declare(strict_types=1);

namespace Stopka\OpenviduPhpClient\Session\Token;

class KurentoOptions
{
    public const BANDWIDTH_UNCONSTRAINED = 0;

    /**
     * @var int
     */
    private int $videoMaxRecvBandwidth;

    /**
     * @var int
     */
    private int $videoMinRecvBandwidth;

    /**
     * @var int
     */
    private int $videoMaxSendBandwidth;

    /**
     * @var int
     */
    private int $videoMinSendBandwidth;

    /**
     * @var string[]
     */
    private array $allowedFilters;

    /**
     * KurentoOptions constructor.
     *
     * @param int      $videoMaxRecvBandwidth
     * @param int      $videoMinRecvBandwidth
     * @param int      $videoMaxSendBandwidth
     * @param int      $videoMinSendBandwidth
     * @param string[] $allowedFilters
     */
    public function __construct(
        int $videoMaxRecvBandwidth = self::BANDWIDTH_UNCONSTRAINED,
        int $videoMinRecvBandwidth = self::BANDWIDTH_UNCONSTRAINED,
        int $videoMaxSendBandwidth = self::BANDWIDTH_UNCONSTRAINED,
        int $videoMinSendBandwidth = self::BANDWIDTH_UNCONSTRAINED,
        array $allowedFilters = []
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
    public function getVideoMaxRecvBandwidth(): int
    {
        return $this->videoMaxRecvBandwidth;
    }

    /**
     * @return int
     */
    public function getVideoMinRecvBandwidth(): int
    {
        return $this->videoMinRecvBandwidth;
    }

    /**
     * @return int
     */
    public function getVideoMaxSendBandwidth(): int
    {
        return $this->videoMaxSendBandwidth;
    }

    /**
     * @return int
     */
    public function getVideoMinSendBandwidth(): int
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
        return [
            'videoMaxRecvBandwidth' => $this->getVideoMaxRecvBandwidth(),
            'videoMinRecvBandwidth' => $this->getVideoMinRecvBandwidth(),
            'videoMinSendBandwidth' => $this->getVideoMinSendBandwidth(),
            'videoMaxSendBandwidth' => $this->getVideoMaxSendBandwidth(),
            'allowedFilters' => $this->getAllowedFilters(),
        ];
    }
}

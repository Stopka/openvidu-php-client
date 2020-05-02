<?php

declare(strict_types=1);

namespace Stopka\OpenviduPhpClient\Session;

use DateTime;

class Publisher
{
    /** @var string */
    private string $streamId;

    /** @var DateTime */
    private DateTime $createdAt;

    /** @var bool */
    private bool $hasVideo;

    /** @var bool */
    private bool $hasAudio;

    /** @var bool */
    private bool $audioActive;

    /** @var bool */
    private bool $videoActive;

    /** @var int */
    private int $frameRate;

    /** @var string */
    private string $typeOfVideo;

    /** @var string */
    private string $videoDimensions;

    public function __construct(
        string $streamId,
        DateTime $createdAt,
        bool $hasAudio,
        bool $hasVideo,
        bool $audioActive,
        bool $videoActive,
        int $frameRate,
        string $typeOfVideo,
        string $videoDimensions
    ) {
        $this->streamId = $streamId;
        $this->createdAt = $createdAt;
        $this->hasAudio = $hasAudio;
        $this->hasVideo = $hasVideo;
        $this->audioActive = $audioActive;
        $this->videoActive = $videoActive;
        $this->frameRate = $frameRate;
        $this->typeOfVideo = $typeOfVideo;
        $this->videoDimensions = $videoDimensions;
    }

    /**
     * @return string
     */
    public function getStreamId(): string
    {
        return $this->streamId;
    }

    /**
     * @return DateTime
     */
    public function getCreatedAt(): DateTime
    {
        return $this->createdAt;
    }

    /**
     * @return bool
     */
    public function isHasVideo(): bool
    {
        return $this->hasVideo;
    }

    /**
     * @return bool
     */
    public function isHasAudio(): bool
    {
        return $this->hasAudio;
    }

    /**
     * @return bool
     */
    public function isAudioActive(): bool
    {
        return $this->audioActive;
    }

    /**
     * @return bool
     */
    public function isVideoActive(): bool
    {
        return $this->videoActive;
    }

    /**
     * @return int
     */
    public function getFrameRate(): int
    {
        return $this->frameRate;
    }

    /**
     * @return string
     */
    public function getTypeOfVideo(): string
    {
        return $this->typeOfVideo;
    }

    /**
     * @return string
     */
    public function getVideoDimensions(): string
    {
        return $this->videoDimensions;
    }

    /**
     * @return mixed[]
     */
    public function getDataArray(): array
    {
        return [
            'streamId' => $this->getStreamId(),
            'createdAt' => $this->getCreatedAt()->getTimestamp(),
            'mediaOptions' => [
                'hasAudio' => $this->isHasAudio(),
                'hasVideo' => $this->isHasVideo(),
                'audioActive' => $this->isAudioActive(),
                'videoActive' => $this->isVideoActive(),
                'frameRate' => $this->getFrameRate(),
                'typeOfVideo' => $this->getTypeOfVideo(),
                'videoDimensions' => $this->getVideoDimensions(),
            ],
        ];
    }

    /**
     * @param mixed[] $data
     * @return Publisher
     */
    public static function createFromDataArray(array $data): Publisher
    {
        $mediaOptions = $data['mediaOptions'];

        return new self(
            $data['streamId'],
            (new DateTime())->setTimestamp($data['createdAt']),
            $mediaOptions['hasAudio'],
            $mediaOptions['hasVideo'],
            $mediaOptions['audioActive'],
            $mediaOptions['videoActive'],
            $mediaOptions['frameRate'],
            $mediaOptions['typeOfVideo'],
            $mediaOptions['videoDimensions']
        );
    }
}

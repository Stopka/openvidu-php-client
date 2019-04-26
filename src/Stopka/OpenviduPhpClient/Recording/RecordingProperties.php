<?php
/**
 * Created by IntelliJ IDEA.
 * User: stopka
 * Date: 13.10.17
 * Time: 12:51
 */

namespace Stopka\OpenviduPhpClient\Recording;


class RecordingProperties
{

    /** @var string */
    private $name;

    /** @var RecordingOutputModeEnum */
    private $outputMode;

    /** @var RecordingLayoutEnum */
    private $recordingLayout;

    /** @var string */
    private $customLayout;

    /** @var string */
    private $resolution;

    /** @var bool */
    private $hasAudio;

    /** @var bool */
    private $hasVideo;

    public function __construct(
        string $name,
        RecordingOutputModeEnum $outputMode,
        RecordingLayoutEnum $recordingLayout,
        string $customLayout,
        string $resolution,
        bool $hasAudio = true,
        bool $hasVideo = true
    ) {
        $this->name = $name;
        $this->outputMode = $outputMode;
        $this->recordingLayout = $recordingLayout;
        $this->customLayout = $customLayout;
        $this->resolution = $resolution;
        $this->hasAudio = $hasAudio;
        $this->hasVideo = $hasVideo;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return RecordingOutputModeEnum
     */
    public function getOutputMode(): RecordingOutputModeEnum
    {
        return $this->outputMode;
    }

    /**
     * @return RecordingLayoutEnum
     */
    public function getRecordingLayout(): RecordingLayoutEnum
    {
        return $this->recordingLayout;
    }

    /**
     * @return string
     */
    public function getCustomLayout(): string
    {
        return $this->customLayout;
    }

    /**
     * @return string
     */
    public function getResolution(): string
    {
        return $this->resolution;
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
    public function isHasVideo(): bool
    {
        return $this->hasVideo;
    }
}

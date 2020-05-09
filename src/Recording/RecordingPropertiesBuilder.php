<?php

declare(strict_types=1);

namespace Stopka\OpenviduPhpClient\Recording;

class RecordingPropertiesBuilder
{

    /** @var string|null */
    private ?string $name = null;

    /** @var RecordingOutputModeEnum */
    private RecordingOutputModeEnum $outputMode;

    /** @var RecordingLayoutEnum */
    private RecordingLayoutEnum $recordingLayout;

    /** @var string|null */
    private ?string $customLayout = null;

    /** @var RecordingResolution|null */
    private ?RecordingResolution $resolution = null;

    /** @var bool */
    private bool $hasAudio = true;

    /** @var bool */
    private bool $hasVideo = true;

    public function __construct()
    {
        $this->outputMode = new RecordingOutputModeEnum(RecordingOutputModeEnum::COMPOSED);
        $this->recordingLayout = new RecordingLayoutEnum(RecordingLayoutEnum::BEST_FIT);
    }

    public function build(): RecordingProperties
    {
        return new RecordingProperties(
            $this->name,
            $this->outputMode,
            $this->recordingLayout,
            $this->customLayout,
            $this->resolution,
            $this->hasAudio,
            $this->hasVideo
        );
    }

    /**
     * @param string|null $name
     * @return static
     */
    public function setName(?string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @param RecordingOutputModeEnum $outputMode
     * @return static
     */
    public function setOutputMode(RecordingOutputModeEnum $outputMode): self
    {
        $this->outputMode = $outputMode;

        return $this;
    }

    /**
     * @param RecordingLayoutEnum $recordingLayout
     * @return static
     */
    public function setRecordingLayout(RecordingLayoutEnum $recordingLayout): self
    {
        $this->recordingLayout = $recordingLayout;

        return $this;
    }

    /**
     * @param string|null $customLayout
     * @return static
     */
    public function setCustomLayout(?string $customLayout): self
    {
        $this->customLayout = $customLayout;
        if (null !== $customLayout) {
            $this->setRecordingLayout(new RecordingLayoutEnum(RecordingLayoutEnum::CUSTOM));
        }

        return $this;
    }

    /**
     * @param RecordingResolution|null $resolution
     * @return static
     */
    public function setResolution(?RecordingResolution $resolution): self
    {
        $this->resolution = $resolution;

        return $this;
    }

    /**
     * @param bool $hasAudio
     * @return static
     */
    public function setHasAudio(bool $hasAudio): self
    {
        $this->hasAudio = $hasAudio;

        return $this;
    }

    /**
     * @param bool $hasVideo
     * @return static
     */
    public function setHasVideo(bool $hasVideo): self
    {
        $this->hasVideo = $hasVideo;

        return $this;
    }
}

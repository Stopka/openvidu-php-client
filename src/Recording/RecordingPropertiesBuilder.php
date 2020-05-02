<?php

declare(strict_types=1);

namespace Stopka\OpenviduPhpClient\Recording;

class RecordingPropertiesBuilder
{

    /** @var string */
    private string $name;

    /** @var RecordingOutputModeEnum */
    private RecordingOutputModeEnum $outputMode;

    /** @var RecordingLayoutEnum */
    private RecordingLayoutEnum $recordingLayout;

    /** @var string */
    private string $customLayout;

    /** @var string */
    private string $resolution;

    /** @var bool */
    private bool $hasAudio;

    /** @var bool */
    private bool $hasVideo;

    public function build(): RecordingProperties
    {
        return new RecordingProperties(
            $this->name,
            $this->outputMode ?? null,
            $this->recordingLayout ?? null,
            $this->customLayout ?? null,
            $this->resolution ?? null,
            $this->hasAudio ?? true,
            $this->hasVideo ?? true
        );
    }

    /**
     * @param string $name
     * @return static
     */
    public function setName(string $name): self
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
     * @param string $customLayout
     * @return static
     */
    public function setCustomLayout(string $customLayout): self
    {
        $this->customLayout = $customLayout;

        return $this;
    }

    /**
     * @param string $resolution
     * @return static
     */
    public function setResolution(string $resolution): self
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

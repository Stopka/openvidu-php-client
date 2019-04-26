<?php
/**
 * Created by IntelliJ IDEA.
 * User: stopka
 * Date: 13.10.17
 * Time: 12:51
 */

namespace Stopka\OpenviduPhpClient\Recording;



class RecordingPropertiesBuilder
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

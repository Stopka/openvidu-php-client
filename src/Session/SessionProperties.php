<?php

declare(strict_types=1);

namespace Stopka\OpenviduPhpClient\Session;

use Stopka\OpenviduPhpClient\MediaModeEnum;
use Stopka\OpenviduPhpClient\Recording\RecordingLayoutEnum;
use Stopka\OpenviduPhpClient\Recording\RecordingModeEnum;
use Stopka\OpenviduPhpClient\Recording\RecordingOutputModeEnum;

class SessionProperties
{
    /** @var MediaModeEnum */
    private MediaModeEnum $mediaMode;

    /** @var RecordingModeEnum */
    private RecordingModeEnum $recordingMode;

    /** @var RecordingOutputModeEnum */
    private RecordingOutputModeEnum $defaultOutputMode;

    /** @var RecordingLayoutEnum */
    private RecordingLayoutEnum $defaultRecordingLayout;

    /** @var string|null */
    private ?string $defaultCustomLayout;

    /** @var string */
    private ?string $customSessionId;


    public function __construct(
        MediaModeEnum $mediaMode,
        RecordingModeEnum $recordingMode,
        RecordingOutputModeEnum $defaultOutputMode,
        RecordingLayoutEnum $layout,
        ?string $defaultCustomLayout = null,
        ?string $customSessionId = null
    ) {
        $this->mediaMode = $mediaMode;
        $this->recordingMode = $recordingMode;
        $this->defaultOutputMode = $defaultOutputMode;
        $this->defaultRecordingLayout = $layout;
        $this->defaultCustomLayout = $defaultCustomLayout;
        $this->customSessionId = $customSessionId;
    }

    /**
     * @return MediaModeEnum
     */
    public function getMediaMode(): MediaModeEnum
    {
        return $this->mediaMode;
    }

    /**
     * @return RecordingModeEnum
     */
    public function getRecordingMode(): RecordingModeEnum
    {
        return $this->recordingMode;
    }

    /**
     * @return RecordingOutputModeEnum
     */
    public function getDefaultOutputMode(): RecordingOutputModeEnum
    {
        return $this->defaultOutputMode;
    }

    /**
     * @return RecordingLayoutEnum
     */
    public function getDefaultRecordingLayout(): RecordingLayoutEnum
    {
        return $this->defaultRecordingLayout;
    }

    /**
     * @return string|null
     */
    public function getDefaultCustomLayout(): ?string
    {
        return $this->defaultCustomLayout;
    }

    /**
     * @return string|null
     */
    public function getCustomSessionId(): ?string
    {
        return $this->customSessionId;
    }
}

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

    /** @var string */
    private string $defaultCustomLayout;

    /** @var string */
    private string $customSessionId;


    public function __construct(
        ?MediaModeEnum $mediaMode = null,
        ?RecordingModeEnum $recordingMode = null,
        ?RecordingOutputModeEnum $defaultOutputMode = null,
        ?RecordingLayoutEnum $layout = null,
        string $defaultCustomLayout = '',
        string $customSessionId = ''
    ) {
        $this->mediaMode = $mediaMode ?? new MediaModeEnum(MediaModeEnum::ROUTED);
        $this->recordingMode = $recordingMode ?? new RecordingModeEnum(RecordingModeEnum::MANUAL);
        $this->defaultOutputMode = $defaultOutputMode ?? new RecordingOutputModeEnum(RecordingOutputModeEnum::COMPOSED);
        $this->defaultRecordingLayout = $layout ?? new RecordingLayoutEnum(RecordingLayoutEnum::BEST_FIT);
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
     * @return string
     */
    public function getDefaultCustomLayout(): string
    {
        return $this->defaultCustomLayout;
    }

    /**
     * @return string
     */
    public function getCustomSessionId(): string
    {
        return $this->customSessionId;
    }
}

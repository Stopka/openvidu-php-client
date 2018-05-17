<?php
/**
 * Created by IntelliJ IDEA.
 * User: stopka
 * Date: 13.10.17
 * Time: 12:51
 */

namespace Stopka\OpenviduPhpClient;


class SessionProperties {
    /** @var string */
    private $mediaMode;

    /** @var string */
    private $recordingMode;

    /** @var string */
    private $defaultRecordingLayout;

    /** @var string */
    private $defaultCustomLayout;

    /** @var string */
    private $customSessionId;


    public function __construct(
        string $mediaMode = MediaMode::ROUTED,
        string $recordingMode = RecordingMode::MANUAL,
        string $layout = RecordingLayout::BEST_FIT,
        string $defaultCustomLayout = "",
        string $customSessionId = ""
    ) {
        $this->mediaMode = $mediaMode;
        $this->recordingMode = $recordingMode;
        $this->defaultRecordingLayout = $layout;
        $this->defaultCustomLayout = $defaultCustomLayout;
        $this->customSessionId = $customSessionId;
    }

    /**
     * @return string
     */
    public function getMediaMode(): string {
        return $this->mediaMode;
    }

    /**
     * @return string
     */
    public function getRecordingMode(): string {
        return $this->recordingMode;
    }

    /**
     * @return string
     */
    public function getDefaultRecordingLayout(): string {
        return $this->defaultRecordingLayout;
    }

    /**
     * @return string
     */
    public function getDefaultCustomLayout(): string {
        return $this->defaultCustomLayout;
    }

    /**
     * @return string
     */
    public function getCustomSessionId(): string {
        return $this->customSessionId;
    }
}
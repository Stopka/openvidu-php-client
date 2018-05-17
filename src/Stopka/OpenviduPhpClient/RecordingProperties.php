<?php
/**
 * Created by IntelliJ IDEA.
 * User: stopka
 * Date: 13.10.17
 * Time: 12:51
 */

namespace Stopka\OpenviduPhpClient;


class RecordingProperties {
    /** @var string */
    private $name;

    /** @var string */
    private $recordingLayout;

    /** @var string */
    private $customLayout;

    public function __construct(
        string $name,
        string $recordingLayout,
        string $customLayout
    ) {
        $this->name = $name;
        $this->recordingLayout = $recordingLayout;
        $this->customLayout = $customLayout;
    }

    /**
     * @return string
     */
    public function getName(): string {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getRecordingLayout(): string {
        return $this->recordingLayout;
    }

    /**
     * @return string
     */
    public function getCustomLayout(): string {
        return $this->customLayout;
    }
}
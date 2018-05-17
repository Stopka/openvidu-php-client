<?php
/**
 * Created by IntelliJ IDEA.
 * User: stopka
 * Date: 13.10.17
 * Time: 12:51
 */

namespace Stopka\OpenviduPhpClient;


class RecordingPropertiesBuilder {
    /** @var string */
    private $name = "";

    /** @var string */
    private $recordingLayout;

    /** @var string */
    private $customLayout;

    public function build(): RecordingProperties {
        return new RecordingProperties(
            $this->name,
            $this->recordingLayout,
            $this->customLayout
        );
    }

    /**
     * @param string $name
     * @return $this
     */
    public function setName(string $name): self {
        $this->name = $name;
        return $this;
    }

    /**
     * @param string $recordingLayout
     * @return $this
     */
    public function setRecordingLayout(string $recordingLayout): self {
        $this->recordingLayout = $recordingLayout;
        return $this;
    }

    /**
     * @param string $customLayout
     * @return $this
     */
    public function setCustomLayout(string $customLayout): self {
        $this->customLayout = $customLayout;
        return $this;
    }
}
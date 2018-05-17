<?php
/**
 * Created by IntelliJ IDEA.
 * User: stopka
 * Date: 13.10.17
 * Time: 12:19
 */

namespace Stopka\OpenviduPhpClient;




class Recording {
    const STATUS_STARTING = "starting";
    const STATUS_STARTED = "started";
    const STATUS_STOPPED = "stopped";
    const STATUS_AVAILABLE = "available";
    const STATUS_FAILED = "failed";

    /** @var string */
    private $status;

    /** @var string */
    private $id;

    /** @var \DateTime */
    private $createdAt;

    /** @var int bytes */
    private $size;

    /** @var string */
    private $sessionId;

    /** @var double seconds */
    private $duration;

    /** @var string */
    private $url;

    /** @var bool */
    private $hasAudio = true;

    /** @var bool */
    private $hasVideo = true;

    /** @var RecordingProperties */
    private $recordingProperties;

    public function __construct(array $values) {
        $this->id = $values['id'];
        $this->sessionId = $values['sessionId'];
        $this->createdAt = new \DateTime('@{'.$values['createdAt'].'}');
        $this->size = $values['size'];
        $this->duration = $values['duration'];
        $this->url = $values['url'];
        $this->hasAudio = $values['hasAudio'];
        $this->hasVideo = $values['hasVideo'];
        $this->status = $values['status'];
        $this->recordingProperties = (new RecordingPropertiesBuilder())
            ->setName($values['name'])
            ->setRecordingLayout($values['recordingLayout'])
            ->build();
    }

    /**
     * @return string
     */
    public function getStatus(): string {
        return $this->status;
    }

    /**
     * @return string
     */
    public function getId(): string {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getName(): string {
        return $this->recordingProperties->getName();
    }

    /**
     * @return string
     */
    public function getRecordingLayout(): string {
        return $this->recordingProperties->getRecordingLayout();
    }

    /**
     * @return string
     */
    public function getSessionId(): string {
        return $this->sessionId;
    }

    /**
     * @return \DateTime
     */
    public function getCreatedAt(): \DateTime {
        return $this->createdAt;
    }

    /**
     * @return int
     */
    public function getSize(): int {
        return $this->size;
    }

    /**
     * @return float
     */
    public function getDuration(): float {
        return $this->duration;
    }

    /**
     * @return string
     */
    public function getUrl(): string {
        return $this->url;
    }

    /**
     * @return bool
     */
    public function hasAudio(): bool {
        return $this->hasAudio;
    }

    /**
     * @return bool
     */
    public function hasVideo(): bool {
        return $this->hasVideo;
    }


}
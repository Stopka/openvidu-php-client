<?php
/**
 * Created by IntelliJ IDEA.
 * User: stopka
 * Date: 13.10.17
 * Time: 12:19
 */

namespace Stopka\OpenviduPhpClient\Recording;

use DateTime;
use Stopka\OpenviduPhpClient\EnumException;

class Recording
{
    /** @var RecordingStatusEnum */
    private $status;

    /** @var string */
    private $id;

    /** @var string */
    private $sessionId;

    /** @var DateTime */
    private $createdAt;

    /** @var int bytes */
    private $size;

    /** @var double seconds */
    private $duration;

    /** @var string */
    private $url;

    /** @var RecordingProperties */
    private $recordingProperties;

    /**
     * Recording constructor.
     * @param array $values
     * @throws EnumException
     */
    public function __construct(array $values)
    {
        $this->id = (string)$values['id'];
        $this->sessionId = (string)$values['sessionId'];
        $this->createdAt = (new DateTime())->setTimestamp($values['createdAt']);
        $this->size = (int)$values['size'];
        $this->duration = (float)$values['duration'];
        $this->url = (string)$values['url'];
        $this->status = new RecordingStatusEnum($values['status']);

        $outputMode = new RecordingOutputModeEnum($values['outputMode']);
        $builder = (new RecordingPropertiesBuilder())
            ->setName($values['name'])
            ->setOutputMode($outputMode)
            ->setHasAudio($values['hasAudio'])
            ->setHasVideo($values['hasVideo']);
        if ($outputMode->equalsString(RecordingOutputModeEnum::COMPOSED) && $values['hasVideo']) {
            $builder->setResolution($values['resolution'])
                ->setRecordingLayout(new RecordingLayoutEnum($values['recordingLayout']));
            if (isset($values['customLayout'])) {
                $builder->setCustomLayout($values['customLayout']);
            }

        }
        $this->recordingProperties = $builder->build();
    }

    /**
     * @return RecordingStatusEnum
     */
    public function getStatus(): RecordingStatusEnum
    {
        return $this->status;
    }

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->recordingProperties->getName();
    }

    /**
     * @return RecordingOutputModeEnum
     */
    public function getOutputMode(): RecordingOutputModeEnum
    {
        return $this->recordingProperties->getOutputMode();
    }

    /**
     * @return RecordingLayoutEnum
     */
    public function getRecordingLayout(): RecordingLayoutEnum
    {
        return $this->recordingProperties->getRecordingLayout();
    }

    /**
     * @return string
     */
    public function getCustomLayout(): string
    {
        return $this->recordingProperties->getCustomLayout();
    }

    /**
     * @return string
     */
    public function getSessionId(): string
    {
        return $this->sessionId;
    }

    /**
     * @return DateTime
     */
    public function getCreatedAt(): DateTime
    {
        return $this->createdAt;
    }

    /**
     * @return int
     */
    public function getSize(): int
    {
        return $this->size;
    }

    /**
     * @return float
     */
    public function getDuration(): float
    {
        return $this->duration;
    }

    /**
     * @return string
     */
    public function getUrl(): string
    {
        return $this->url;
    }

    /**
     * @return string
     */
    public function getResolution(): string
    {
        return $this->recordingProperties->getResolution();
    }

    /**
     * @return bool
     */
    public function hasAudio(): bool
    {
        return $this->recordingProperties->isHasAudio();
    }

    /**
     * @return bool
     */
    public function hasVideo(): bool
    {
        return $this->recordingProperties->isHasVideo();
    }


}

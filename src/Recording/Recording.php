<?php

declare(strict_types=1);

namespace Stopka\OpenviduPhpClient\Recording;

use DateTimeImmutable;
use Stopka\OpenviduPhpClient\InvalidDataException;

class Recording
{
    /**
     * @var RecordingStatusEnum
     */
    private RecordingStatusEnum $status;

    /**
     * @var string
     */
    private string $id;

    /**
     * @var string
     */
    private string $sessionId;

    /**
     * @var DateTimeImmutable
     */
    private DateTimeImmutable $createdAt;

    /**
     * @var int bytes
     */
    private int $size;

    /**
     * @var float seconds
     */
    private float $duration;

    /**
     * @var string
     */
    private string $url;

    /**
     * @var RecordingProperties
     */
    private RecordingProperties $recordingProperties;

    /**
     * Recording constructor.
     *
     * @param  mixed[] $values
     * @throws InvalidDataException
     */
    public function __construct(array $values)
    {
        $this->id = (string)$values['id'];
        $this->sessionId = (string)$values['sessionId'];
        $this->createdAt = (new DateTimeImmutable())->setTimestamp((int)$values['createdAt']);
        $this->size = (int)$values['size'];
        $this->duration = (float)$values['duration'];
        $this->url = (string)$values['url'];
        $this->status = new RecordingStatusEnum((string)$values['status']);

        $outputMode = new RecordingOutputModeEnum((string)$values['outputMode']);
        $builder = (new RecordingPropertiesBuilder())
            ->setName((string)$values['name'])
            ->setOutputMode($outputMode)
            ->setHasAudio((bool)$values['hasAudio'])
            ->setHasVideo((bool)$values['hasVideo']);
        if ((bool)$values['hasVideo'] && RecordingOutputModeEnum::COMPOSED === $outputMode->getValue()) {
            if (isset($values['customLayout'])) {
                $builder->setCustomLayout((string)$values['customLayout']);
            }
            $builder->setResolution(RecordingResolution::createFromString((string)$values['resolution']))
                ->setRecordingLayout(new RecordingLayoutEnum($values['recordingLayout']));
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
     * @return string|null
     */
    public function getName(): ?string
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
     * @return string|null
     */
    public function getCustomLayout(): ?string
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
     * @return DateTimeImmutable
     */
    public function getCreatedAt(): DateTimeImmutable
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
     * @return RecordingResolution|null
     */
    public function getResolution(): ?RecordingResolution
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

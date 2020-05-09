<?php

declare(strict_types=1);

namespace Stopka\OpenviduPhpClient\Recording;

class RecordingResolution
{
    public const DELIMITER = 'x';
    public const MIN = 100;
    public const MAX = 1999;

    /** @var int */
    private int $width;

    /** @var int */
    private int $height;

    public function __construct(int $width, int $height)
    {
        if ($width < self::MIN || $width > self::MAX || $height < self::MIN || $height > self::MAX) {
            throw new InvalidArgumentException(
                sprintf('Values for both width and height must be between %d and %d', self::MIN, self::MAX)
            );
        }
        $this->width = $width;
        $this->height = $height;
    }

    /**
     * @return int
     */
    public function getWidth(): int
    {
        return $this->width;
    }

    /**
     * @return int
     */
    public function getHeight(): int
    {
        return $this->height;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return implode(self::DELIMITER, [$this->getWidth(), $this->getHeight()]);
    }

    /**
     * @param string $resolution <width>x<height>
     * @return RecordingResolution
     */
    public static function createFromString(string $resolution): self
    {
        [$width, $height] = explode(self::DELIMITER, $resolution . self::DELIMITER);
        if (!is_numeric($width) || !is_numeric($height)) {
            throw new InvalidArgumentException(
                sprintf('Invalid resolution format, expected <width:int>%s<height:int>.', self::DELIMITER)
            );
        }

        return new self((int)$width, (int)$height);
    }
}

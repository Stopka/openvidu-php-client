<?php

declare(strict_types=1);

namespace Stopka\OpenviduPhpClient\Recording;

use Stopka\OpenviduPhpClient\Enum\EnumTrait;

class RecordingOutputModeEnum
{
    use EnumTrait;

    public const COMPOSED = 'COMPOSED';
    public const INDIVIDUAL = 'INDIVIDUAL';

    /**
     * @return string[]
     */
    public static function getValues(): array
    {
        return [
            self::COMPOSED,
            self::INDIVIDUAL,
        ];
    }
}

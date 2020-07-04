<?php

declare(strict_types=1);

namespace Stopka\OpenviduPhpClient\Recording;

use MyCLabs\Enum\Enum;

/**
 * Class RecordingOutputModeEnum
 * @package Stopka\OpenviduPhpClient\Recording
 * @extends Enum<string>
 */
class RecordingOutputModeEnum extends Enum
{

    public const COMPOSED = 'COMPOSED';
    public const INDIVIDUAL = 'INDIVIDUAL';
}

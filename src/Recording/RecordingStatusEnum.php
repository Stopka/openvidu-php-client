<?php

declare(strict_types=1);

namespace Stopka\OpenviduPhpClient\Recording;

use MyCLabs\Enum\Enum;

/**
 * Class RecordingStatusEnum
 * @package Stopka\OpenviduPhpClient\Recording
 * @extends Enum<string>
 */
class RecordingStatusEnum extends Enum
{

    public const STARTING = 'starting';
    public const STARTED = 'started';
    public const STOPPED = 'stopped';
    public const READY = 'ready';
    public const FAILED = 'failed';
}

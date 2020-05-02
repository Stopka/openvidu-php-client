<?php

declare(strict_types=1);

namespace Stopka\OpenviduPhpClient\Recording;

use Stopka\OpenviduPhpClient\Enum\EnumTrait;

class RecordingStatusEnum
{
    use EnumTrait;

    public const STARTING = 'starting';
    public const STARTED = 'started';
    public const STOPPED = 'stopped';
    public const READY = 'ready';
    public const FAILED = 'failed';

    /**
     * @return string[]
     */
    public function getValues(): array
    {
        return [
            self::STARTING,
            self::STARTED,
            self::STOPPED,
            self::READY,
            self::FAILED,
        ];
    }
}

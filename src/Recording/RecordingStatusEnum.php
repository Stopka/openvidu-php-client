<?php


namespace Stopka\OpenviduPhpClient\Recording;


use Stopka\OpenviduPhpClient\Enum;

class RecordingStatusEnum
{
    use Enum;

    const STARTING = "starting";
    const STARTED = "started";
    const STOPPED = "stopped";
    const READY = "ready";
    const FAILED = "failed";

    public function getValues(): array
    {
        return [
            self::STARTING,
            self::STARTED,
            self::STOPPED,
            self::READY,
            self::FAILED
        ];
    }


}

<?php


namespace Stopka\OpenviduPhpClient\Recording;


use Stopka\OpenviduPhpClient\Enum;

class RecordingOutputModeEnum
{
    use Enum;

    const COMPOSED = "COMPOSED";
    const INDIVIDUAL = "INDIVIDUAL";

    public function getValues(): array
    {
        return [
            self::COMPOSED,
            self::INDIVIDUAL
        ];
    }


}

<?php

declare(strict_types=1);

namespace Stopka\OpenviduPhpClient\Tests\Enum;

use Stopka\OpenviduPhpClient\Enum\EnumTrait;

class TestingEnum
{
    use EnumTrait;

    public const FOO = 'Foo';
    public const BAR = 'Bar';

    /**
     * @return string[]
     */
    public static function getValues(): array
    {
        return [
            self::FOO,
            self::BAR,
        ];
    }
}

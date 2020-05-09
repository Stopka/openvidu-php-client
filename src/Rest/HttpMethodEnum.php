<?php

declare(strict_types=1);

namespace Stopka\OpenviduPhpClient\Rest;

use Stopka\OpenviduPhpClient\Enum\EnumTrait;

class HttpMethodEnum
{
    use EnumTrait;

    public const POST = 'post';
    public const PUT = 'put';
    public const GET = 'get';
    public const DELETE = 'delete';

    /**
     * @return string[]
     */
    public static function getValues(): array
    {
        return [
            self::POST,
            self::PUT,
            self::GET,
            self::DELETE,
        ];
    }
}

<?php

declare(strict_types=1);

namespace Stopka\OpenviduPhpClient\Rest;

use MyCLabs\Enum\Enum;

/**
 * Class HttpMethodEnum
 * @package Stopka\OpenviduPhpClient\Rest
 * @extends Enum<string>
 */
final class HttpMethodEnum extends Enum
{
    public const POST = 'post';
    public const PUT = 'put';
    public const GET = 'get';
    public const DELETE = 'delete';
}

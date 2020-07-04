<?php

declare(strict_types=1);

namespace Stopka\OpenviduPhpClient;

use MyCLabs\Enum\Enum;

/**
 * Class OpenViduRoleEnum
 * @package Stopka\OpenviduPhpClient
 * @extends Enum<string>
 */
final class OpenViduRoleEnum extends Enum
{
    public const SUBSCRIBER = 'SUBSCRIBER';
    public const PUBLISHER = 'PUBLISHER';
    public const MODERATOR = 'MODERATOR';
}

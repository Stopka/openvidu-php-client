<?php

declare(strict_types=1);

namespace Stopka\OpenviduPhpClient;

use Stopka\OpenviduPhpClient\Enum\EnumTrait;

final class OpenViduRoleEnum
{
    use EnumTrait;

    public const SUBSCRIBER = 'SUBSCRIBER';
    public const PUBLISHER = 'PUBLISHER';
    public const MODERATOR = 'MODERATOR';

    /**
     * @return string[]
     */
    public function getValues(): array
    {
        return [
            self::SUBSCRIBER,
            self::PUBLISHER,
            self::MODERATOR,
        ];
    }
}

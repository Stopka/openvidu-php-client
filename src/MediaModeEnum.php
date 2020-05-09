<?php

declare(strict_types=1);

namespace Stopka\OpenviduPhpClient;

use Stopka\OpenviduPhpClient\Enum\EnumTrait;

final class MediaModeEnum
{
    use EnumTrait;

    /**
     * <i>(not available yet)</i> The session will attempt to transmit streams
     * directly between clients
     */
    public const RELAYED = 'RELAYED';

    /**
     * The session will transmit streams using OpenVidu Media Server
     */
    public const ROUTED = 'ROUTED';

    /**
     * @return string[]
     */
    public static function getValues(): array
    {
        return [
            self::RELAYED,
            self::ROUTED,
        ];
    }
}

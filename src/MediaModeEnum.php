<?php

declare(strict_types=1);

namespace Stopka\OpenviduPhpClient;

use MyCLabs\Enum\Enum;

/**
 * Class MediaModeEnum
 * @package    Stopka\OpenviduPhpClient
 * @extends Enum<string>
 */
final class MediaModeEnum extends Enum
{
    /**
     * <i>(not available yet)</i> The session will attempt to transmit streams
     * directly between clients
     */
    public const RELAYED = 'RELAYED';

    /**
     * The session will transmit streams using OpenVidu Media Server
     */
    public const ROUTED = 'ROUTED';
}

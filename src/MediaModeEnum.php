<?php
/**
 * Created by IntelliJ IDEA.
 * User: stopka
 * Date: 13.10.17
 * Time: 14:02
 */

namespace Stopka\OpenviduPhpClient;


class MediaModeEnum
{
    use Enum;

    /**
     * <i>(not available yet)</i> The session will attempt to transmit streams
     * directly between clients
     */
    const RELAYED = "RELAYED";

    /**
     * The session will transmit streams using OpenVidu Media Server
     */
    const ROUTED = "ROUTED";


    public function getValues(): array
    {
        return [
            self::RELAYED,
            self::ROUTED
        ];
    }
}

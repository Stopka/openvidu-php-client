<?php

declare(strict_types=1);

namespace Stopka\OpenviduPhpClient\Recording;

use Stopka\OpenviduPhpClient\Enum\EnumTrait;

class RecordingModeEnum
{
    use EnumTrait;

    /**
     * The session is recorded automatically as soon as the first client publishes a
     * stream to the session. It is automatically stopped after last user leaves the
     * session (or until you call
     * {@link io.openvidu.java.client.OpenVidu#stopRecording(String)}).
     */
    public const ALWAYS = 'ALWAYS';

    /**
     * The session is not recorded automatically. To record the session, you must
     * call {@link io.openvidu.java.client.OpenVidu#startRecording(String)} method.
     * To stop the recording, you must call
     * {@link io.openvidu.java.client.OpenVidu#stopRecording(String)}.
     */
    public const MANUAL = 'MANUAL';

    /**
     * @return string[]
     */
    public static function getValues(): array
    {
        return [
            self::ALWAYS,
            self::MANUAL,
        ];
    }
}

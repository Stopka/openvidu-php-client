<?php

declare(strict_types=1);

namespace Stopka\OpenviduPhpClient\Recording;

use MyCLabs\Enum\Enum;

/**
 * Class RecordingModeEnum
 * @package Stopka\OpenviduPhpClient\Recording
 * @extends Enum<string>
 */
class RecordingModeEnum extends Enum
{

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
}

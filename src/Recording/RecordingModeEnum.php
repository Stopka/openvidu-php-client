<?php
/**
 * Created by IntelliJ IDEA.
 * User: stopka
 * Date: 13.10.17
 * Time: 14:02
 */

namespace Stopka\OpenviduPhpClient\Recording;


use Stopka\OpenviduPhpClient\Enum;

class RecordingModeEnum
{
    use Enum;
    /**
     * The session is recorded automatically as soon as the first client publishes a
     * stream to the session. It is automatically stopped after last user leaves the
     * session (or until you call
     * {@link io.openvidu.java.client.OpenVidu#stopRecording(String)}).
     */
    const ALWAYS = "ALWAYS";

    /**
     * The session is not recorded automatically. To record the session, you must
     * call {@link io.openvidu.java.client.OpenVidu#startRecording(String)} method.
     * To stop the recording, you must call
     * {@link io.openvidu.java.client.OpenVidu#stopRecording(String)}.
     */
    const MANUAL = "MANUAL";

    public function getValues(): array
    {
        return [
            self::ALWAYS,
            self::MANUAL
        ];
    }


}

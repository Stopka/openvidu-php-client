<?php
/**
 * Created by IntelliJ IDEA.
 * User: stopka
 * Date: 13.10.17
 * Time: 12:36
 */

namespace Stopka\OpenviduPhpClient;


use Throwable;

class OpenViduException extends \RuntimeException {
    const CODE_GENERIC = 999;

    const CODE_TRANSPORT = 803;
    const CODE_TRANSPORT_RESPONSE = 802;
    const CODE_TRANSPORT_REQUEST = 801;

    const CODE_MEDIA_MUTE = 307;
    const CODE_MEDIA_NOT_A_WEB_ENDPOINT = 306;
    const CODE_MEDIA_RTP_ENDPOINT = 305;
    const CODE_MEDIA_WEBRTC_ENDPOINT = 304;
    const CODE_MEDIA_ENDPOINT = 303;
    const CODE_MEDIA_SDP = 302;
    const CODE_MEDIA_GENERIC = 301;

    const CODE_ROOM_CANNOT_BE_CREATED = 204;
    const CODE_ROOM_CLOSED = 203;
    const CODE_ROOM_NOT_FOUND = 202;
    const CODE_ROOM_GENERIC = 201;

    const CODE_USER_NOT_STREAMING = 105;
    const CODE_EXISTING_USER_IN_ROOM = 104;
    const CODE_USER_CLOSED = 103;
    const CODE_USER_NOT_FOUND = 102;
    const CODE_USER_GENERIC = 101;

    const CODE_USER_UNAUTHORIZED = 401;
    const CODE_ROLE_NOT_FOUND = 402;
    const CODE_SESSIONID_CANNOT_BE_CREATED = 403;
    const CODE_TOKEN_CANNOT_BE_CREATED = 404;

    const CODE_USER_METADATA_FORMAT_INVALID = 500;

    public function __construct($message = "", $code = self::CODE_GENERIC, Throwable $previous = null) {
        parent::__construct($message, $code, $previous);
    }

}
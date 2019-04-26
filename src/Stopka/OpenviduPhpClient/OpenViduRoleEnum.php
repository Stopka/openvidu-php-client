<?php
/**
 * Created by IntelliJ IDEA.
 * User: stopka
 * Date: 13.10.17
 * Time: 14:02
 */

namespace Stopka\OpenviduPhpClient;


class OpenViduRoleEnum
{
    use Enum;

    const SUBSCRIBER = 'SUBSCRIBER';
    const PUBLISHER = 'PUBLISHER';
    const MODERATOR = 'MODERATOR';

    public function getValues(): array
    {
        return [
            self::SUBSCRIBER,
            self::PUBLISHER,
            self::MODERATOR
        ];
    }


}

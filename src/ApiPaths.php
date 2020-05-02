<?php

declare(strict_types=1);

namespace Stopka\OpenviduPhpClient;

final class ApiPaths
{
    public const SESSIONS = 'api/sessions';
    public const TOKENS = 'api/tokens';
    public const RECORDINGS = 'api/recordings';
    public const RECORDINGS_START = 'api/recordings/start';
    public const RECORDINGS_STOP = 'api/recordings/stop';

    private function __construct()
    {
    }
}

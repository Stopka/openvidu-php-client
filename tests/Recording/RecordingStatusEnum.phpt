<?php

declare(strict_types=1);

use Stopka\OpenviduPhpClient\Recording\RecordingStatusEnum;
use Tester\Assert;

require __DIR__ . '/../bootstrap.php';

Assert::same(
    [
        'STARTING' => 'starting',
        'STARTED' => 'started',
        'STOPPED' => 'stopped',
        'READY' => 'ready',
        'FAILED' => 'failed',
    ],
    RecordingStatusEnum::toArray()
);

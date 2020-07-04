<?php

declare(strict_types=1);

use Stopka\OpenviduPhpClient\Recording\RecordingOutputModeEnum;
use Tester\Assert;

require __DIR__ . '/../bootstrap.php';

Assert::same(
    [
        'COMPOSED' => 'COMPOSED',
        'INDIVIDUAL' => 'INDIVIDUAL',
    ],
    RecordingOutputModeEnum::toArray()
);

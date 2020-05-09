<?php

declare(strict_types=1);

use Stopka\OpenviduPhpClient\Recording\RecordingModeEnum;
use Tester\Assert;

require __DIR__ . '/../bootstrap.php';

Assert::same(
    ['ALWAYS', 'MANUAL'],
    RecordingModeEnum::getValues()
);

<?php

declare(strict_types=1);

use Stopka\OpenviduPhpClient\Recording\RecordingStatusEnum;
use Tester\Assert;

require __DIR__ . '/../bootstrap.php';

Assert::same(
    ['starting', 'started', 'stopped', 'ready', 'failed'],
    RecordingStatusEnum::getValues()
);

<?php

declare(strict_types=1);

use Stopka\OpenviduPhpClient\MediaModeEnum;
use Tester\Assert;

require __DIR__ . '/bootstrap.php';

Assert::same(
    [
        'RELAYED' => 'RELAYED',
        'ROUTED' => 'ROUTED',
    ],
    MediaModeEnum::toArray()
);

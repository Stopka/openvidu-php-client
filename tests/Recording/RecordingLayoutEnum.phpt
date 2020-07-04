<?php

declare(strict_types=1);

use Stopka\OpenviduPhpClient\Recording\RecordingLayoutEnum;
use Tester\Assert;

require __DIR__ . '/../bootstrap.php';

Assert::same(
    [
        'BEST_FIT' => 'BEST_FIT',
        'PICTURE_IN_PICTURE' => 'PICTURE_IN_PICTURE',
        'VERTICAL_PRESENTATION' => 'VERTICAL_PRESENTATION',
        'HORIZONTAL_PRESENTATION' => 'HORIZONTAL_PRESENTATION',
        'CUSTOM' => 'CUSTOM',
    ],
    RecordingLayoutEnum::toArray()
);

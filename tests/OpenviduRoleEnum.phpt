<?php

declare(strict_types=1);

use Stopka\OpenviduPhpClient\OpenViduRoleEnum;
use Tester\Assert;

require __DIR__ . '/bootstrap.php';

Assert::same(
    [
        'SUBSCRIBER' => 'SUBSCRIBER',
        'PUBLISHER' => 'PUBLISHER',
        'MODERATOR' => 'MODERATOR',
    ],
    OpenViduRoleEnum::toArray()
);

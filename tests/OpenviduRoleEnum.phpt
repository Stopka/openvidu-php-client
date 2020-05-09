<?php

use Stopka\OpenviduPhpClient\OpenViduRoleEnum;
use Tester\Assert;

require __DIR__ . '/bootstrap.php';

Assert::same(
    ['SUBSCRIBER', 'PUBLISHER', 'MODERATOR'],
    OpenViduRoleEnum::getValues()
);

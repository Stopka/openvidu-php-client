<?php

declare(strict_types=1);

use Stopka\OpenviduPhpClient\Rest\HttpMethodEnum;
use Tester\Assert;

require __DIR__ . '/../bootstrap.php';

Assert::same(
    ['post', 'put', 'get', 'delete'],
    HttpMethodEnum::getValues()
);

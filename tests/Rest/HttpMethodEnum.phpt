<?php

declare(strict_types=1);

use Stopka\OpenviduPhpClient\Rest\HttpMethodEnum;
use Tester\Assert;

require __DIR__ . '/../bootstrap.php';

Assert::same(
    [
        'POST' => 'post',
        'PUT' => 'put',
        'GET' => 'get',
        'DELETE' => 'delete',
    ],
    HttpMethodEnum::toArray()
);

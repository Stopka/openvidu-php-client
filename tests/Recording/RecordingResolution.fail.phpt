<?php

/**
 * @dataProvider RecordingResolution.failDataProvider.ini
 */

declare(strict_types=1);

use Stopka\OpenviduPhpClient\Recording\InvalidArgumentException;
use Stopka\OpenviduPhpClient\Recording\RecordingResolution;
use Tester\Assert;
use Tester\Environment;

require __DIR__ . '/../bootstrap.php';

$args = Environment::loadData();

Assert::throws(
    fn() => RecordingResolution::createFromString($args['string']),
    InvalidArgumentException::class,
    $args['message']
);

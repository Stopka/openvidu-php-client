<?php

/**
 * @dataProvider RecordingResolution.failDataProvider.ini
 */

declare(strict_types=1);

use Stopka\OpenviduPhpClient\Recording\RecordingResolution;
use Tester\Assert;
use Tester\Environment;

require __DIR__ . '/../bootstrap.php';

$args = Environment::loadData();

$resolutionString = '1024x720';
$resolution = RecordingResolution::createFromString($resolutionString);
Assert::same(1024, $resolution->getWidth());
Assert::same(720, $resolution->getHeight());
Assert::same($resolutionString, (string)$resolution);

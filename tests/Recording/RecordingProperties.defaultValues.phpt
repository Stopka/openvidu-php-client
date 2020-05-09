<?php

declare(strict_types=1);

use Stopka\OpenviduPhpClient\Recording\RecordingLayoutEnum;
use Stopka\OpenviduPhpClient\Recording\RecordingOutputModeEnum;
use Stopka\OpenviduPhpClient\Recording\RecordingPropertiesBuilder;
use Tester\Assert;

require __DIR__ . '/../bootstrap.php';

$builder = new RecordingPropertiesBuilder();
$properties = $builder->build();

Assert::null($properties->getName());
Assert::same(RecordingOutputModeEnum::COMPOSED, (string)$properties->getOutputMode());
Assert::true($properties->isHasAudio());
Assert::true($properties->isHasVideo());
Assert::same(RecordingLayoutEnum::BEST_FIT, (string)$properties->getRecordingLayout());
Assert::null($properties->getCustomLayout());
Assert::null($properties->getResolution());

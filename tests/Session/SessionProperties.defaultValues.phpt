<?php

declare(strict_types=1);

use Stopka\OpenviduPhpClient\MediaModeEnum;
use Stopka\OpenviduPhpClient\Recording\RecordingLayoutEnum;
use Stopka\OpenviduPhpClient\Recording\RecordingModeEnum;
use Stopka\OpenviduPhpClient\Recording\RecordingOutputModeEnum;
use Stopka\OpenviduPhpClient\Session\SessionPropertiesBuilder;
use Tester\Assert;

require __DIR__ . '/../bootstrap.php';

$builder = new SessionPropertiesBuilder();
$properties = $builder->build();

Assert::null($properties->getCustomSessionId());
Assert::null($properties->getDefaultCustomLayout());
Assert::same(RecordingOutputModeEnum::COMPOSED, (string)$properties->getDefaultOutputMode());
Assert::same(RecordingLayoutEnum::BEST_FIT, (string)$properties->getDefaultRecordingLayout());
Assert::same(MediaModeEnum::ROUTED, (string)$properties->getMediaMode());
Assert::same(RecordingModeEnum::MANUAL, (string)$properties->getRecordingMode());

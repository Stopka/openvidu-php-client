<?php

declare(strict_types=1);

use Stopka\OpenviduPhpClient\MediaModeEnum;
use Stopka\OpenviduPhpClient\Recording\RecordingLayoutEnum;
use Stopka\OpenviduPhpClient\Recording\RecordingModeEnum;
use Stopka\OpenviduPhpClient\Recording\RecordingOutputModeEnum;
use Stopka\OpenviduPhpClient\Session\SessionPropertiesBuilder;
use Tester\Assert;

require __DIR__ . '/../bootstrap.php';

$sessionIdExample = 'someSessionId';
$customLayourExample = 'someCutomLayout';

$builder = (new SessionPropertiesBuilder())
    ->setCustomSessionId($sessionIdExample)
    ->setDefaultCustomLayout($customLayourExample)
    ->setDefaultRecordingLayout(new RecordingLayoutEnum(RecordingLayoutEnum::CUSTOM))
    ->setDefaultOutputMode(new RecordingOutputModeEnum(RecordingOutputModeEnum::INDIVIDUAL))
    ->setMediaMode(new MediaModeEnum(MediaModeEnum::RELAYED))
    ->setRecordingMode(new RecordingModeEnum(RecordingModeEnum::ALWAYS));
$properties = $builder->build();

Assert::same($sessionIdExample, $properties->getCustomSessionId());
Assert::same($customLayourExample, $properties->getDefaultCustomLayout());
Assert::same(RecordingOutputModeEnum::INDIVIDUAL, (string)$properties->getDefaultOutputMode());
Assert::same(RecordingLayoutEnum::CUSTOM, (string)$properties->getDefaultRecordingLayout());
Assert::same(MediaModeEnum::RELAYED, (string)$properties->getMediaMode());
Assert::same(RecordingModeEnum::ALWAYS, (string)$properties->getRecordingMode());

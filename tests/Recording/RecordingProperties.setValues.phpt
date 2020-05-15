<?php

declare(strict_types=1);

use Stopka\OpenviduPhpClient\Recording\RecordingLayoutEnum;
use Stopka\OpenviduPhpClient\Recording\RecordingOutputModeEnum;
use Stopka\OpenviduPhpClient\Recording\RecordingPropertiesBuilder;
use Stopka\OpenviduPhpClient\Recording\RecordingResolution;
use Tester\Assert;

require __DIR__ . '/../bootstrap.php';

$customLayoutExample = 'someLayout';
$nameExample = 'someName';
$resolutionExample = '480x640';

$builder = (new RecordingPropertiesBuilder())
    ->setCustomLayout($customLayoutExample)
    ->setRecordingLayout(new RecordingLayoutEnum(RecordingLayoutEnum::CUSTOM))
    ->setHasAudio(false)
    ->setHasVideo(false)
    ->setName($nameExample)
    ->setOutputMode(new RecordingOutputModeEnum(RecordingOutputModeEnum::INDIVIDUAL))
    ->setResolution(RecordingResolution::createFromString($resolutionExample));
$properties = $builder->build();

Assert::same($nameExample, $properties->getName());
Assert::same(RecordingOutputModeEnum::INDIVIDUAL, (string)$properties->getOutputMode());
Assert::false($properties->isHasAudio());
Assert::false($properties->isHasVideo());
Assert::same(RecordingLayoutEnum::CUSTOM, (string)$properties->getRecordingLayout());
Assert::same($customLayoutExample, $properties->getCustomLayout());
Assert::same($resolutionExample, (string)$properties->getResolution());

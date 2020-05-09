<?php

declare(strict_types=1);

use Stopka\OpenviduPhpClient\Recording\Recording;
use Stopka\OpenviduPhpClient\Recording\RecordingLayoutEnum;
use Stopka\OpenviduPhpClient\Recording\RecordingOutputModeEnum;
use Stopka\OpenviduPhpClient\Recording\RecordingStatusEnum;
use Tester\Assert;

require __DIR__ . '/../bootstrap.php';

/** @var string $jsonData */
$jsonData = file_get_contents(__DIR__ . '/Recording.dataProvider.json');
$data = json_decode($jsonData, true, 512, JSON_THROW_ON_ERROR);

$recording = new Recording($data);
Assert::same('320x240', (string)$recording->getResolution());
Assert::same('someLayout', $recording->getCustomLayout());
Assert::same(RecordingLayoutEnum::CUSTOM, (string)$recording->getRecordingLayout());
Assert::same(
    RecordingOutputModeEnum::COMPOSED,
    (string)$recording->getOutputMode()
);
Assert::same('someName', $recording->getName());
Assert::true($recording->hasVideo());
Assert::false($recording->hasAudio());
Assert::same(1589056810, $recording->getCreatedAt()->getTimestamp());
Assert::same(1024, $recording->getSize());
Assert::same(120.2, $recording->getDuration());
Assert::same('someId', $recording->getId());
Assert::same('someSessionId', $recording->getSessionId());
Assert::same('some/url', $recording->getUrl());
Assert::same(RecordingStatusEnum::STARTED, (string)$recording->getStatus());

<?php

declare(strict_types=1);

use Stopka\OpenviduPhpClient\ApiPaths;
use Stopka\OpenviduPhpClient\InvalidDataException;
use Stopka\OpenviduPhpClient\OpenVidu;
use Stopka\OpenviduPhpClient\OpenViduException;
use Stopka\OpenviduPhpClient\Recording\RecordingLayoutEnum;
use Stopka\OpenviduPhpClient\Recording\RecordingOutputModeEnum;
use Stopka\OpenviduPhpClient\Recording\RecordingResolution;
use Stopka\OpenviduPhpClient\Recording\RecordingStatusEnum;
use Stopka\OpenviduPhpClient\Rest\RestClient;
use Stopka\OpenviduPhpClient\Rest\RestClientException;
use Stopka\OpenviduPhpClient\Rest\RestResponse;
use Tester\Assert;

require __DIR__ . '/bootstrap.php';

$sessionIdExample = 'someSessionId';
$recordingIdExample = 'someRecordingId';
$urlExample = 'someUrl';
$nameExample = 'someName';
$layoutExample = 'someLayout';
$sizeExample = 7;
$durationExample = 8.5;
$resolutionExample = new RecordingResolution(1024, 720);
$dateExample = new DateTime();

$restResponse = Mockery::mock(RestResponse::class);
$restResponse->shouldReceive('getArray')
    ->andReturn(
        [
            'id' => $recordingIdExample,
            'sessionId' => $sessionIdExample,
            'createdAt' => $dateExample->getTimestamp(),
            'size' => $sizeExample,
            'duration' => $durationExample,
            'url' => $urlExample,
            'status' => RecordingStatusEnum::STARTED,
            'outputMode' => RecordingOutputModeEnum::COMPOSED,
            'name' => $nameExample,
            'hasAudio' => true,
            'hasVideo' => true,
            'resolution' => ((string)$resolutionExample),
            'recordingLayout' => RecordingLayoutEnum::CUSTOM,
            'customLayout' => $layoutExample,
        ]
    );

$restClient = Mockery::mock(RestClient::class);
$restClient->shouldReceive('get')
    ->once()
    ->with(ApiPaths::RECORDINGS . '/' . $recordingIdExample)
    ->andReturn($restResponse);

$openvidu = new OpenVidu($restClient);

$recording = $openvidu->getRecording($recordingIdExample);

Assert::same($sessionIdExample, $recording->getSessionId());
Assert::true($recording->hasAudio());
Assert::true($recording->hasVideo());
Assert::same($recordingIdExample, $recording->getId());
Assert::same($urlExample, $recording->getUrl());
Assert::same($nameExample, $recording->getName());
Assert::same(RecordingLayoutEnum::CUSTOM, (string)$recording->getRecordingLayout());
Assert::same($layoutExample, $recording->getCustomLayout());
Assert::same($sizeExample, $recording->getSize());
Assert::same($durationExample, $recording->getDuration());
Assert::notNull($recording->getResolution());
Assert::same($resolutionExample->getWidth(), $recording->getResolution()->getWidth());
Assert::same($resolutionExample->getHeight(), $recording->getResolution()->getHeight());
Assert::same($dateExample->getTimestamp(), $recording->getCreatedAt()->getTimestamp());
Assert::same(RecordingStatusEnum::STARTED, (string)$recording->getStatus());
Assert::same(RecordingOutputModeEnum::COMPOSED, (string)$recording->getOutputMode());

$restClient->shouldReceive('get')
    ->once()
    ->andThrow(new InvalidDataException('Some exception'));
Assert::exception(
    fn() => $openvidu->getRecording($recordingIdExample),
    OpenViduException::class,
    'Could not retrieve recording'
);

$restClient->shouldReceive('get')
    ->once()
    ->andThrow(Mockery::mock(RestClientException::class));
Assert::exception(
    fn() => $openvidu->getRecording($recordingIdExample),
    OpenViduException::class,
    'Could not retrieve recording'
);

Mockery::close();

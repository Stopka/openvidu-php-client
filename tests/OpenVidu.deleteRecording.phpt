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

$recordingIdExample = 'someRecordingId';

$restResponse = Mockery::mock(RestResponse::class);

$restClient = Mockery::mock(RestClient::class);
$restClient->shouldReceive('delete')
    ->once()
    ->with(ApiPaths::RECORDINGS . '/' . $recordingIdExample)
    ->andReturn($restResponse);

$openvidu = new OpenVidu($restClient);

$openvidu->deleteRecording($recordingIdExample);

$restClient->shouldReceive('delete')
    ->once()
    ->andThrow(Mockery::mock(RestClientException::class));
Assert::exception(
    static function () use ($openvidu, $recordingIdExample): void {
        $openvidu->deleteRecording($recordingIdExample);
    },
    OpenViduException::class,
    'Could not delete recording'
);

Mockery::close();

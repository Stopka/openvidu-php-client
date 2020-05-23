<?php

declare(strict_types=1);

use Stopka\OpenviduPhpClient\MediaModeEnum;
use Stopka\OpenviduPhpClient\OpenVidu;
use Stopka\OpenviduPhpClient\OpenViduException;
use Stopka\OpenviduPhpClient\Recording\RecordingModeEnum;
use Stopka\OpenviduPhpClient\Recording\RecordingOutputModeEnum;
use Stopka\OpenviduPhpClient\Rest\RestClient;
use Stopka\OpenviduPhpClient\Rest\RestResponse;
use Tester\Assert;

require __DIR__ . '/bootstrap.php';

$sessionIdExample = 'someSessionId';

$restResponse = Mockery::mock(RestResponse::class);
$restResponse->shouldReceive('getStringInArrayKey')
    ->andReturn($sessionIdExample);

$restClient = Mockery::mock(RestClient::class);
$restClient->shouldReceive('post')
    ->andReturn($restResponse);

$openvidu = new OpenVidu($restClient);
$activeSessions = $openvidu->getActiveSessions();
Assert::count(0, $activeSessions);

$session = $openvidu->createSessionFromDataArray(
    [
        'sessionId' => $sessionIdExample,
        'recording' => false,
        'mediaMode' => MediaModeEnum::RELAYED,
        'recordingMode' => RecordingModeEnum::MANUAL,
        'defaultOutputMode' => RecordingOutputModeEnum::COMPOSED,
        'connections' => [
            'content' => [],
        ],
    ]
);
$activeSessions = $openvidu->getActiveSessions();
Assert::count(1, $activeSessions);
Assert::same($session->getSessionId(), $activeSessions[$sessionIdExample]->getSessionId());
Assert::same($sessionIdExample, $session->getSessionId());

Assert::exception(
    fn() => $openvidu->createSessionFromDataArray(
        [
            'sessionId' => $sessionIdExample,
            'recording' => false,
            'mediaMode' => 'invalidMedia',
            'recordingMode' => RecordingModeEnum::MANUAL,
            'defaultOutputMode' => RecordingOutputModeEnum::COMPOSED,
            'connections' => [
                'content' => [],
            ],
        ]
    ),
    OpenViduException::class,
    'Could not create session'
);

Mockery::close();

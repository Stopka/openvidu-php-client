<?php

declare(strict_types=1);

use Stopka\OpenviduPhpClient\ApiPaths;
use Stopka\OpenviduPhpClient\InvalidDataException;
use Stopka\OpenviduPhpClient\MediaModeEnum;
use Stopka\OpenviduPhpClient\OpenVidu;
use Stopka\OpenviduPhpClient\OpenViduException;
use Stopka\OpenviduPhpClient\Recording\RecordingModeEnum;
use Stopka\OpenviduPhpClient\Recording\RecordingOutputModeEnum;
use Stopka\OpenviduPhpClient\Rest\RestClient;
use Stopka\OpenviduPhpClient\Rest\RestClientException;
use Stopka\OpenviduPhpClient\Rest\RestResponse;
use Tester\Assert;

require __DIR__ . '/bootstrap.php';

$getSessionId = fn(int $number): string => md5((string)$number);
$getSessionData = fn(int $number): array => [
    'sessionId' => $getSessionId($number),
    'recording' => (bool)$number,
    'mediaMode' => MediaModeEnum::RELAYED,
    'recordingMode' => RecordingModeEnum::MANUAL,
    'defaultOutputMode' => RecordingOutputModeEnum::COMPOSED,
    'connections' => ['content' => []],
];

$restResponse = Mockery::mock(RestResponse::class);

$restClient = Mockery::mock(RestClient::class);
$restClient->shouldReceive('get')
    ->times(4)
    ->with(ApiPaths::SESSIONS)
    ->andReturn($restResponse);

$openvidu = new OpenVidu($restClient);
Assert::count(0, $openvidu->getActiveSessions());

$restResponse->shouldReceive('getArrayInArrayKey')
    ->times(2)
    ->andReturn(
        [
            $getSessionData(0),
            $getSessionData(1),
            $getSessionData(2),
        ]
    );
Assert::true($openvidu->fetch());
Assert::false($openvidu->fetch());
$activeSessions = $openvidu->getActiveSessions();
Assert::count(3, $activeSessions);
foreach ([0, 1, 2] as $number) {
    $sessionId = $getSessionId($number);
    /** @phpstan-ignore-next-line it wrongly sees $activeSessions as empty array */
    Assert::same($sessionId, $activeSessions[$sessionId]->getSessionId());
}

$restResponse->shouldReceive('getArrayInArrayKey')
    ->times(2)
    ->andReturn(
        [
            $getSessionData(0),
            $getSessionData(3),
        ]
    );
Assert::true($openvidu->fetch());
Assert::false($openvidu->fetch());
$activeSessions = $openvidu->getActiveSessions();
Assert::count(2, $activeSessions);
foreach ([0, 3] as $number) {
    $sessionId = $getSessionId($number);
    /** @phpstan-ignore-next-line it wrongly sees $activeSessions as empty array */
    Assert::same($sessionId, $activeSessions[$sessionId]->getSessionId());
}

$restClient->shouldReceive('get')
    ->once()
    ->with(ApiPaths::SESSIONS)
    ->andThrow(new InvalidDataException('Some exception'));
Assert::exception(
    fn(): bool => $openvidu->fetch(),
    OpenViduException::class,
    'Sessions fetching failed'
);

$restClient->shouldReceive('get')
    ->once()
    ->with(ApiPaths::SESSIONS)
    ->andThrow(Mockery::mock(RestClientException::class));
Assert::exception(
    fn(): bool => $openvidu->fetch(),
    OpenViduException::class,
    'Sessions fetching failed'
);

Mockery::close();

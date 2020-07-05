<?php

declare(strict_types=1);

use Stopka\OpenviduPhpClient\MediaModeEnum;
use Stopka\OpenviduPhpClient\OpenViduException;
use Stopka\OpenviduPhpClient\OpenViduRoleEnum;
use Stopka\OpenviduPhpClient\Recording\RecordingLayoutEnum;
use Stopka\OpenviduPhpClient\Recording\RecordingModeEnum;
use Stopka\OpenviduPhpClient\Recording\RecordingOutputModeEnum;
use Stopka\OpenviduPhpClient\Rest\RestClient;
use Stopka\OpenviduPhpClient\Rest\RestClientException;
use Stopka\OpenviduPhpClient\Rest\RestResponse;
use Stopka\OpenviduPhpClient\Session\Session;
use Stopka\OpenviduPhpClient\Session\Token\KurentoOptionsBuilder;
use Stopka\OpenviduPhpClient\Session\Token\TokenOptionsBuilder;
use Tester\Assert;

require __DIR__ . '/../bootstrap.php';

$sessionIdExample = 'someSessionId';
$tokenExample = 'someToken';

$sessionResponse = Mockery::mock(RestResponse::class);
$sessionResponse->shouldReceive('getStringInArrayKey')
    ->andReturn($sessionIdExample);

$tokenResponse = Mockery::mock(RestResponse::class);
$tokenResponse->shouldReceive('getStringInArrayKey')
    ->andReturn($tokenExample);

$restClient = Mockery::mock(RestClient::class);
$restClient->shouldReceive('post')
    ->once()
    ->with(
        'api/sessions',
        [
            'mediaMode' => MediaModeEnum::ROUTED,
            'recordingMode' => RecordingModeEnum::MANUAL,
            'defaultOutputMode' => RecordingOutputModeEnum::COMPOSED,
            'defaultRecordingLayout' => RecordingLayoutEnum::BEST_FIT,
            'defaultCustomLayout' => null,
            'customSessionId' => null,
        ]
    )
    ->andReturn($sessionResponse);
$restClient->shouldReceive('post')
    ->once()
    ->with(
        'api/tokens',
        [
            'session' => $sessionIdExample,
            'role' => OpenViduRoleEnum::PUBLISHER,
            'data' => null,
        ]
    )
    ->andReturn($tokenResponse);
$restClient->shouldReceive('post')
    ->once()
    ->with(
        'api/tokens',
        [
            'session' => $sessionIdExample,
            'role' => OpenViduRoleEnum::MODERATOR,
            'data' => 'some data',
            'kurentoOptions' => [
                'videoMaxRecvBandwidth' => 11,
                'videoMinRecvBandwidth' => 8,
                'videoMinSendBandwidth' => 7,
                'videoMaxSendBandwidth' => 10,
                'allowedFilters' => ['someFilter'],
            ],
        ]
    )
    ->andThrow(new RestClientException('Wrong', 404));

$session = Session::createFromProperties($restClient);
$tokenOptions = $session->generateToken();

Assert::same($tokenExample, $tokenOptions);

$tokenOptions = (new TokenOptionsBuilder())
    ->setData('some data')
    ->setRole(new OpenViduRoleEnum(OpenViduRoleEnum::MODERATOR))
    ->setKurentoOptions(
        (new KurentoOptionsBuilder())
            ->setAllowedFilters(['someFilter'])
            ->setVideoMaxSendBandwidth(10)
            ->setVideoMinSendBandwidth(7)
            ->setVideoMaxRecvBandwidth(11)
            ->setVideoMinRecvBandwidth(8)
            ->build()
    )
    ->build();

Assert::exception(
    static function () use ($session, $tokenOptions): void {
        $session->generateToken($tokenOptions);
    },
    OpenViduException::class
);

Mockery::close();

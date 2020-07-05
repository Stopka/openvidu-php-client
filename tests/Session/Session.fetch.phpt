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
use Stopka\OpenviduPhpClient\Session\Publisher;
use Stopka\OpenviduPhpClient\Session\Session;
use Stopka\OpenviduPhpClient\Session\Token\KurentoOptionsBuilder;
use Stopka\OpenviduPhpClient\Session\Token\TokenOptionsBuilder;
use Tester\Assert;

require __DIR__ . '/../bootstrap.php';

$sessionIdExample = 'someSessionId';
$tokenExample = 'someToken';
$nowTimestamp = (new DateTimeImmutable())->getTimestamp();

$sessionResponse = Mockery::mock(RestResponse::class);
$sessionResponse->shouldReceive('getStringInArrayKey')
    ->andReturn($sessionIdExample);

$fetchResponse = Mockery::mock(RestResponse::class);
$fetchResponse->shouldReceive('getArray')
    ->andReturn(
        [
            'sessionId' => $sessionIdExample,
            'createdAt' => $nowTimestamp,
            'recording' => true,
            'mediaMode' => MediaModeEnum::RELAYED,
            'recordingMode' => RecordingModeEnum::ALWAYS,
            'defaultOutputMode' => RecordingOutputModeEnum::INDIVIDUAL,
            'defaultRecordingLayout' => RecordingLayoutEnum::CUSTOM,
            'defaultCustomLayout' => 'customLayout',
            'connections' => [
                'count' => 1,
                'content' => [
                    [
                        'connectionId' => 'conn1',
                        'createdAt' => $nowTimestamp,
                        'role' => OpenViduRoleEnum::PUBLISHER,
                        'token' => 'someToken',
                        'location' => 'someLocation',
                        'platform' => 'somePlatform',
                        'serverData' => 'someServerData',
                        'clientData' => 'someClientData',
                        'publishers' => [
                            [
                                'streamId' => 'somePublisherStreamId',
                                'createdAt' => $nowTimestamp,
                                'mediaOptions' => [
                                    'hasAudio' => true,
                                    'hasVideo' => true,
                                    'audioActive' => true,
                                    'videoActive' => true,
                                    'frameRate' => 25,
                                    'typeOfVideo' => 'camera',
                                    'videoDimensions' => '640x480',
                                ],
                            ],
                        ],
                        'subscribers' => [
                            ['streamId' => 'streamId1'],
                            ['streamId' => 'streamId2'],
                        ],
                    ],
                ],
            ],
        ]
    );

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
$restClient->shouldReceive('get')
    ->once()
    ->with('api/sessions/' . $sessionIdExample)
    ->andReturn($fetchResponse);

$session = Session::createFromProperties($restClient);

Assert::true($session->fetch());

$connections = $session->getActiveConnections();

Assert::count(1, $connections);

$connection = reset($connections);
Assert::same($nowTimestamp, $connection->getCreatedAt()->getTimestamp());
Assert::same(OpenViduRoleEnum::PUBLISHER, (string)$connection->getRole());
Assert::same('someClientData', $connection->getClientData());
Assert::same('conn1', $connection->getConnectionId());
Assert::same('someLocation', $connection->getLocation());
Assert::same('somePlatform', $connection->getPlatform());
Assert::same('someToken', $connection->getToken());
Assert::same('someServerData', $connection->getServerData());

$subscribers = $connection->getSubscribers();
Assert::count(2, $subscribers);
Assert::contains('streamId1', $subscribers);
Assert::contains('streamId2', $subscribers);

$publishers = $connection->getPublishers();
Assert::count(1, $publishers);
/** @var Publisher $publisher */
$publisher = reset($publishers);
Assert::same($nowTimestamp, $publisher->getCreatedAt()->getTimestamp());
Assert::true($publisher->isHasVideo());
Assert::true($publisher->isHasAudio());
Assert::true($publisher->isAudioActive());
Assert::true($publisher->isVideoActive());
Assert::same(25, $publisher->getFrameRate());
Assert::same('camera', $publisher->getTypeOfVideo());
Assert::same('640x480', $publisher->getVideoDimensions());
Assert::same('somePublisherStreamId', $publisher->getStreamId());


Mockery::close();

<?php

declare(strict_types=1);

use Stopka\OpenviduPhpClient\OpenVidu;
use Stopka\OpenviduPhpClient\Rest\RestClient;
use Stopka\OpenviduPhpClient\Rest\RestResponse;
use Stopka\OpenviduPhpClient\Session\SessionPropertiesBuilder;
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

$session = $openvidu->createSession((new SessionPropertiesBuilder())->build());
$activeSessions = $openvidu->getActiveSessions();
Assert::count(1, $activeSessions);
Assert::same($session->getSessionId(), $activeSessions[$sessionIdExample]->getSessionId());
Assert::same($sessionIdExample, $session->getSessionId());

Mockery::close();

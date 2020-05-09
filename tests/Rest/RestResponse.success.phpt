<?php

/**
 * @dataProvider RestResponse.dataProvider.ini
 */

declare(strict_types=1);

use Psr\Http\Message\ResponseInterface;
use Stopka\OpenviduPhpClient\Rest\RestResponse;
use Tester\Assert;
use Tester\Environment;

require __DIR__ . '/../bootstrap.php';

$args = Environment::loadData();

$content = Mockery::mock(\Psr\Http\Message\StreamInterface::class);
$content->shouldReceive('rewind');
$content->shouldReceive('getContents')
    ->andReturn($args['contentJson']);

$httpResponse = Mockery::mock(ResponseInterface::class);
$httpResponse->shouldReceive('getHeader')
    ->andReturn(['Content-type' => 'application/json']);
$httpResponse->shouldReceive('getBody')
    ->andReturn($content);

$response = new RestResponse($httpResponse);
$response->getArray();
/** @var callable $callback */
$callback = [$response, $args['method']];
$callbackParams = json_decode($args['paramsJson'], true, 512, JSON_THROW_ON_ERROR);
Assert::same(
    json_decode($args['resultJson'], true, 512, JSON_THROW_ON_ERROR),
    call_user_func_array($callback, $callbackParams)
);

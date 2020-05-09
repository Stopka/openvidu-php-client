<?php

/**
 * @dataProvider RestResponse.invalidProvider.ini
 */

declare(strict_types=1);

use Psr\Http\Message\ResponseInterface;
use Stopka\OpenviduPhpClient\Rest\RestResponse;
use Stopka\OpenviduPhpClient\Rest\RestResponseInvalidException;
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
    ->andReturn(['Content-type' => $args['contentType']]);
$httpResponse->shouldReceive('getBody')
    ->andReturn($content);

$response = new RestResponse($httpResponse);

Assert::exception(
    static fn() => $response->getArray(),
    RestResponseInvalidException::class,
    $args['message']
);

<?php

/**
 * @dataProvider RestClient.requestProvider.ini
 */

declare(strict_types=1);

use GuzzleHttp\ClientInterface;
use GuzzleHttp\Exception\RequestException;
use Psr\Http\Message\ResponseInterface;
use Stopka\OpenviduPhpClient\Rest\RestClient;
use Stopka\OpenviduPhpClient\Rest\RestResponseException;
use Tester\Assert;
use Tester\Environment;

require __DIR__ . '/../bootstrap.php';

$args = Environment::loadData();
$method = (string)$args['method'];
$withData = (bool)$args['withData'];

$httpResponse = Mockery::mock(ResponseInterface::class);
$httpResponse->shouldReceive('getHeader')
    ->andReturn([]);

Assert::exception(
    static function () use ($method, $withData, $httpResponse): void {
        $urlExample = 'url/';
        $requestParams = [
            $method,
            $urlExample,
        ];
        $dataExample = [
            'key' => 'value',
        ];
        if ($withData) {
            $requestParams[] = ['json' => $dataExample];
        }


        $exception = Mockery::mock(RequestException::class);
        $exception->shouldReceive('getResponse')
            ->andReturn($httpResponse);
        $httpClient = Mockery::mock(ClientInterface::class);
        $httpClient->shouldReceive('request')
            ->times(1)
            ->with(...$requestParams)
            ->andThrows($exception);


        $client = new RestClient($httpClient);
        /** @var callable $restClientMethodCallable */
        $restClientMethodCallable = [$client, $method];
        if ($withData) {
            call_user_func($restClientMethodCallable, $urlExample, $dataExample);
        } else {
            call_user_func($restClientMethodCallable, $urlExample);
        }

        Mockery::close();
    },
    RestResponseException::class
);

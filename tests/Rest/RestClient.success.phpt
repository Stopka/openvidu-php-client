<?php

/**
 * @dataProvider RestClient.requestProvider.ini
 */

declare(strict_types=1);

use GuzzleHttp\ClientInterface;
use Psr\Http\Message\ResponseInterface;
use Stopka\OpenviduPhpClient\Rest\RestClient;
use Tester\Assert;
use Tester\Environment;

require __DIR__ . '/../bootstrap.php';

$args = Environment::loadData();
$method = (string)$args['method'];
$withData = (bool)$args['withData'];

Assert::noError(
    static function () use ($method, $withData): void {
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

        $httpResponse = Mockery::mock(ResponseInterface::class);
        $httpClient = Mockery::mock(ClientInterface::class);
        $httpClient->shouldReceive('request')
            ->times(1)
            ->with(...$requestParams)
            ->andReturn($httpResponse);

        $client = new RestClient($httpClient);
        /** @var callable $restClientMethodCallable */
        $restClientMethodCallable = [$client, $method];
        if ($withData) {
            call_user_func($restClientMethodCallable, $urlExample, $dataExample);
        } else {
            call_user_func($restClientMethodCallable, $urlExample);
        }

        Mockery::close();
    }
);

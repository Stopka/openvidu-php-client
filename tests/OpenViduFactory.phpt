<?php

declare(strict_types=1);

use Stopka\OpenviduPhpClient\OpenViduFactory;
use Stopka\OpenviduPhpClient\Rest\HttpClient\ClientFactory;
use Tester\Assert;

require __DIR__ . '/bootstrap.php';

$urlExample = 'some.domain/';
$someSecret = 'secret';
$noVerify = false;

$factory = new OpenViduFactory($urlExample, $someSecret, $noVerify);
$config = $factory->createHttpClientConfig();
Assert::same($urlExample, $config->getBaseUri());
Assert::same($someSecret, $config->getPassword());
Assert::same($noVerify, $config->isVerify());

$testOptions = static function ($options) use ($urlExample, $someSecret, $noVerify): void {
    Assert::same($urlExample, (string)$options['base_uri']);
    Assert::same([ClientFactory::AUTH_USER, $someSecret], $options['auth']);
    Assert::same($noVerify, $options['verify']);
};

$httpClientFactory = $factory->createHttpClientFactory();
$options = $httpClientFactory->buildOptions($config);
$testOptions($options);
$httpClient = $httpClientFactory->createClient($config);
$testOptions($httpClient->getConfig());

$httpClient = $factory->createHttpClient();
$testOptions($httpClient->getConfig());

$restClient = $factory->createRestClient();

$openvidu = $factory->create();

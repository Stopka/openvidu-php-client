<?php

/**
 * @dataProvider ClientFactory.argsProvider.ini
 */

declare(strict_types=1);

use Stopka\OpenviduPhpClient\Rest\HttpClient\ClientConfig;
use Stopka\OpenviduPhpClient\Rest\HttpClient\ClientFactory;
use Tester\Assert;
use Tester\Environment;

require __DIR__ . '/../../bootstrap.php';

$args = Environment::loadData();
$factory = new ClientFactory();
$config = new ClientConfig(
    (string)$args['baseUri'],
    (string)$args['password'],
    (bool)$args['verify']
);

$client = $factory->createClient($config);
Assert::same($args['baseUri'], (string)$client->getConfig('base_uri'));
Assert::same('application/json', $client->getConfig('headers')['Accept']);
Assert::same(['OPENVIDUAPP', (string)$args['password']], $client->getConfig('auth'));
Assert::same((bool)$args['verify'], $client->getConfig('verify'));

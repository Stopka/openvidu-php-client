<?php

declare(strict_types=1);

use Stopka\OpenviduPhpClient\OpenViduRoleEnum;
use Stopka\OpenviduPhpClient\Session\Token\KurentoOptionsBuilder;
use Stopka\OpenviduPhpClient\Session\Token\TokenOptionsBuilder;
use Tester\Assert;

require __DIR__ . '/../../bootstrap.php';

$dataExample = 'someData';
$kurentoOptions = (new KurentoOptionsBuilder())->build();

$builder = (new TokenOptionsBuilder())
    ->setRole(new OpenViduRoleEnum(OpenViduRoleEnum::SUBSCRIBER))
    ->setData($dataExample)
    ->setKurentoOptions($kurentoOptions);
$options = $builder->build();

Assert::same(OpenViduRoleEnum::SUBSCRIBER, (string)$options->getRole());
Assert::same($dataExample, $options->getData());
Assert::same($kurentoOptions, $options->getKurentoOptions());

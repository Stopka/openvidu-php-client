<?php

declare(strict_types=1);

use Stopka\OpenviduPhpClient\OpenViduRoleEnum;
use Stopka\OpenviduPhpClient\Session\Token\TokenOptionsBuilder;
use Tester\Assert;

require __DIR__ . '/../../bootstrap.php';

$builder = new TokenOptionsBuilder();
$options = $builder->build();

Assert::same(OpenViduRoleEnum::PUBLISHER, (string)$options->getRole());
Assert::null($options->getData());
Assert::null($options->getKurentoOptions());

<?php

declare(strict_types=1);

use Stopka\OpenviduPhpClient\Session\Token\KurentoOptionsBuilder;
use Tester\Assert;

require __DIR__ . '/../../bootstrap.php';

$builder = new KurentoOptionsBuilder();
$options = $builder->build();

Assert::same(0, $options::BANDWIDTH_UNCONSTRAINED);
Assert::count($options::BANDWIDTH_UNCONSTRAINED, $options->getAllowedFilters());
Assert::same($options::BANDWIDTH_UNCONSTRAINED, $options->getVideoMaxRecvBandwidth());
Assert::same($options::BANDWIDTH_UNCONSTRAINED, $options->getVideoMaxSendBandwidth());
Assert::same($options::BANDWIDTH_UNCONSTRAINED, $options->getVideoMinRecvBandwidth());
Assert::same($options::BANDWIDTH_UNCONSTRAINED, $options->getVideoMinSendBandwidth());
Assert::same(
    [
        'videoMaxRecvBandwidth' => $options::BANDWIDTH_UNCONSTRAINED,
        'videoMinRecvBandwidth' => $options::BANDWIDTH_UNCONSTRAINED,
        'videoMinSendBandwidth' => $options::BANDWIDTH_UNCONSTRAINED,
        'videoMaxSendBandwidth' => $options::BANDWIDTH_UNCONSTRAINED,
        'allowedFilters' => [],
    ],
    $options->getDataArray()
);

<?php

declare(strict_types=1);

use Stopka\OpenviduPhpClient\Session\Token\KurentoOptionsBuilder;
use Tester\Assert;

require __DIR__ . '/../../bootstrap.php';

$someBandwidth = 256;
$someFilters = ['filterOne', 'filterTwo'];

$builder = (new KurentoOptionsBuilder())
    ->setVideoMaxRecvBandwidth($someBandwidth + 0)
    ->setVideoMinRecvBandwidth($someBandwidth + 1)
    ->setVideoMinSendBandwidth($someBandwidth + 2)
    ->setVideoMaxSendBandwidth($someBandwidth + 3)
    ->setAllowedFilters($someFilters);
$options = $builder->build();

$bandwidth = $someBandwidth;
Assert::same($someFilters, $options->getAllowedFilters());
Assert::same($someBandwidth + 0, $options->getVideoMaxRecvBandwidth());
Assert::same($someBandwidth + 1, $options->getVideoMinRecvBandwidth());
Assert::same($someBandwidth + 2, $options->getVideoMinSendBandwidth());
Assert::same($someBandwidth + 3, $options->getVideoMaxSendBandwidth());
$bandwidth = $someBandwidth;
Assert::same(
    [
        'videoMaxRecvBandwidth' => $someBandwidth + 0,
        'videoMinRecvBandwidth' => $someBandwidth + 1,
        'videoMinSendBandwidth' => $someBandwidth + 2,
        'videoMaxSendBandwidth' => $someBandwidth + 3,
        'allowedFilters' => $someFilters,
    ],
    $options->getDataArray()
);

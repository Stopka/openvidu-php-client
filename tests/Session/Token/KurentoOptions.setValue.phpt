<?php

declare(strict_types=1);

use Stopka\OpenviduPhpClient\Session\Token\KurentoOptionsBuilder;
use Tester\Assert;

require __DIR__ . '/../../bootstrap.php';

$someBandwidth = 256;
$someFilters = ['filterOne', 'filterTwo'];

$bandwidth = $someBandwidth;
$builder = new KurentoOptionsBuilder();
$builder->setVideoMaxRecvBandwidth($bandwidth++);
$builder->setVideoMinRecvBandwidth($bandwidth++);
$builder->setVideoMinSendBandwidth($bandwidth++);
$builder->setVideoMaxSendBandwidth($bandwidth++);
$builder->setAllowedFilters($someFilters);
$options = $builder->build();

$bandwidth = $someBandwidth;
Assert::same($someFilters, $options->getAllowedFilters());
Assert::same($bandwidth++, $options->getVideoMaxRecvBandwidth());
Assert::same($bandwidth++, $options->getVideoMinRecvBandwidth());
Assert::same($bandwidth++, $options->getVideoMinSendBandwidth());
Assert::same($bandwidth++, $options->getVideoMaxSendBandwidth());
$bandwidth = $someBandwidth;
Assert::same(
    [
        'videoMaxRecvBandwidth' => $bandwidth++,
        'videoMinRecvBandwidth' => $bandwidth++,
        'videoMinSendBandwidth' => $bandwidth++,
        'videoMaxSendBandwidth' => $bandwidth++,
        'allowedFilters' => $someFilters,
    ],
    $options->getDataArray()
);

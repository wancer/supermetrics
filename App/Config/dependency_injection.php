<?php

use Psr\Container\ContainerInterface;
use PhpParser\JsonDecoder;
use Supermetrics\App\Controller\Controller;
use Supermetrics\App\Service\Api\{Api, Transport, DataObjectBuilder};
use Supermetrics\App\Service\StatisticsCalculator;
use Supermetrics\Kernel\{Config, Router};
use Supermetrics\Kernel\Abstraction\{ConfigInterface, RouterInterface};

return [
    ContainerInterface::class => DI\autowire(\DI\Container::class)->lazy(),
    ConfigInterface::class => DI\autowire( Config::class)->lazy(),
    RouterInterface::class => DI\autowire( Router::class)->lazy(),
    GuzzleHttp\ClientInterface::class => DI\autowire(\GuzzleHttp\Client::class)->lazy(),
    JsonDecoder::class => DI\autowire(JsonDecoder::class)->lazy(),

    Api::class => DI\autowire(Api::class)->lazy(),
    Transport::class => DI\autowire(Transport::class)->lazy(),

    DataObjectBuilder::class => DI\autowire(DataObjectBuilder::class)->lazy(),

    StatisticsCalculator::class => DI\autowire(StatisticsCalculator::class)->lazy(),

    Controller::class => DI\autowire(Controller::class)->lazy(),
];
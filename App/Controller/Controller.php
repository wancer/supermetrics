<?php

namespace Supermetrics\App\Controller;

use Psr\Http\Message\ResponseInterface;
use Supermetrics\App\Service\Api\Api;
use Supermetrics\App\Service\Api\Exception\ApiException;
use Supermetrics\App\Service\StatisticsCalculator;
use Supermetrics\Kernel\Abstraction\AbstractController;
use Supermetrics\Kernel\Abstraction\ConfigInterface;

/**
 * Class Controller
 */
class Controller extends AbstractController
{
    /**
     * @var Api
     */
    private $apiService;

    /**
     * @var StatisticsCalculator
     */
    private $statisticsCalculator;

    /**
     * @var ConfigInterface
     */
    private $config;

    /**
     * Controller constructor.
     *
     * @param Api $api
     * @param StatisticsCalculator $calculator
     * @param ConfigInterface $config
     */
    public function __construct(Api $api, StatisticsCalculator $calculator, ConfigInterface $config)
    {
        $this->apiService = $api;
        $this->statisticsCalculator = $calculator;
        $this->config = $config;
    }

    /**
     * @return ResponseInterface
     */
    public function welcome(): ResponseInterface
    {
        $response = [
            'message' => 'Hello. Please read README.md to get instructions.',
        ];

        return $this->jsonResponse($response);
    }

    /**
     * @return ResponseInterface
     * @throws ApiException
     * @throws \Supermetrics\Kernel\Exception\ConfigException
     */
    public function statistics(): ResponseInterface
    {
        $apiConfig = $this->config->get('api');
        $register = $this
            ->apiService
            ->register($apiConfig['clientId'], $apiConfig['email'], $apiConfig['name']);

        for ($page = $apiConfig['minPage']; $page <= $apiConfig['maxPage']; $page++)
        {
            $posts = $this->apiService->posts($register->getToken(), $page);
            $this->statisticsCalculator->processPosts($posts);
        }

        $this->statisticsCalculator->calculateAverages();

        $statistics = $this->statisticsCalculator->get();

        return $this->jsonResponse($statistics);
    }
}
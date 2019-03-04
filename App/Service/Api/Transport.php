<?php

namespace Supermetrics\App\Service\Api;

use GuzzleHttp\ClientInterface;
use Psr\Http\Message\ResponseInterface;
use Supermetrics\Kernel\Abstraction\ConfigInterface;

/**
 * Class ApiTransport
 */
class Transport
{
    /**
     * @var ClientInterface
     */
    private $client;

    /**
     * @var array
     */
    private $config;

    /**
     * Api constructor.
     *
     * @param ClientInterface $client
     * @param ConfigInterface $config
     *
     * @throws \Supermetrics\Kernel\Exception\ConfigException
     */
    public function __construct(ClientInterface $client, ConfigInterface $config)
    {
        $this->client = $client;
        $this->config = $config->get('api');
    }

    /**
     * @param string $method
     * @param array $data
     *
     * @return \Psr\Http\Message\ResponseInterface
     *
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function post(string $method, array $data = []): ResponseInterface
    {
        $response = $response = $this->client->request(
            'POST',
            $this->config['base_url'] . $method,
            [
                'headers' => [
                    'Content-Type' => 'application/json',
                ],
                'body' => json_encode($data),
            ]
        );

        return $response;
    }

    /**
     * @param string $method
     * @param array $data
     *
     * @return ResponseInterface
     *
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function get(string $method, array $data = []): ResponseInterface
    {
        $response = $response = $this->client->request(
            'GET',
            $this->config['base_url'] . $method . '?' . http_build_query($data)
        );

        return $response;
    }
}
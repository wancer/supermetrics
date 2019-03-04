<?php

namespace Supermetrics\App\Service\Api;

use GuzzleHttp\Exception\GuzzleException;
use Supermetrics\App\Service\Api\DataObject\Posts;
use Supermetrics\App\Service\Api\DataObject\Register;
use Supermetrics\App\Service\Api\Exception\ApiException;

/**
 * Class Api
 */
class Api
{
    /**
     * @var Transport
     */
    protected $transport;
    /**
     * @var DataObjectBuilder
     */
    protected $builder;

    /**
     * Api constructor.
     *
     * @param Transport $transport
     * @param DataObjectBuilder $builder
     */
    public function __construct(Transport $transport, DataObjectBuilder $builder)
    {
        $this->transport = $transport;
        $this->builder = $builder;
    }

    /**
     * @param string $clientId
     * @param string $email
     * @param string $name
     *
     * @return Register
     *
     * @throws ApiException
     */
    public function register(string $clientId, string $email, string $name): Register
    {
        $requestData = [
            'client_id' => $clientId,
            'email' => $email,
            'name' => $name,
        ];

        try
        {
            $response = $response = $this->transport->post('register', $requestData);
            $register = $this->builder->buildRegister($response->getBody()->getContents());
        }
        catch (GuzzleException $e)
        {
            throw new ApiException('Error during API call:' . $e->getMessage());
        }

        return $register;
    }

    /**
     * @param string $token
     * @param int $page
     *
     * @return Posts
     *
     * @throws ApiException
     */
    public function posts(string $token, int $page): Posts
    {
        $requestData = [
            'sl_token' => $token,
            'page' => $page,
        ];

        try
        {
            $response = $response = $this->transport->get('posts', $requestData);
            $posts = $this->builder->buildPosts($response->getBody()->getContents());
        }
        catch (GuzzleException $e)
        {
            throw new ApiException('Error during API call:' . $e->getMessage());
        }

        return $posts;
    }
}
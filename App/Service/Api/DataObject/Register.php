<?php

namespace Supermetrics\App\Service\Api\DataObject;

/**
 * Class Register
 */
class Register
{
    /**
     * @var string
     */
    private $token;

    /**
     * Register constructor.
     *
     * @param string $token
     */
    public function __construct(string $token)
    {
        $this->token = $token;
    }

    /**
     * @return string
     */
    public function getToken(): string
    {
        return $this->token;
    }
}
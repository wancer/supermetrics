<?php

namespace Supermetrics\App\Service\Api;

use PhpParser\JsonDecoder;
use Supermetrics\App\Service\Api\DataObject\Posts;
use Supermetrics\App\Service\Api\DataObject\Register;

/**
 * Class DataObjectBuilder
 */
class DataObjectBuilder
{
    private $decoder;

    /**
     * DataObjectBuilder constructor.
     *
     * @param JsonDecoder $jsonDecoder
     */
    public function __construct(JsonDecoder $jsonDecoder)
    {
        $this->decoder = $jsonDecoder;
    }

    /**
     * @param string $content
     *
     * @return Register
     */
    public function buildRegister(string $content): Register
    {
        $parsedContent = $this->decoder->decode($content);

        return new Register($parsedContent['data']['sl_token']);
    }

    /**
     * @param string $content
     *
     * @return Posts
     *
     * @throws Exception\ApiException
     */
    public function buildPosts(string $content): Posts
    {
        $parsedContent = $this->decoder->decode($content);

        return new Posts($parsedContent['data']['posts'], $parsedContent['data']['page']);
    }
}
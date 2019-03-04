<?php

namespace Supermetrics\Kernel\Abstraction;

use Supermetrics\Kernel\Exception\ConfigException;

/**
 * Interface ConfigInterface
 *
 * @package Supermetrics\Kernel\Abstraction
 */
interface ConfigInterface
{
    /**
     * @param string $key
     *
     * @return mixed
     *
     * @throws ConfigException
     */
    public function get(string $key);
}
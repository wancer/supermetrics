<?php

namespace Supermetrics\Kernel\Abstraction;

use Supermetrics\Kernel\Exception\RouterException;

/**
 * Interface RouterInterface
 *
 * @package Supermetrics\Kernel\Abstraction
 */
interface RouterInterface
{
    /**
     * @param string $route
     *
     * @return bool
     */
    public function matchRoute(string $route): bool;

    /**
     * @param string $route
     *
     * @return string
     *
     * @throws RouterException
     */
    public function getControllerClass(string $route): string;

    /**
     * @param string $route
     *
     * @return string
     *
     * @throws RouterException
     */
    public function getControllerMethod(string $route): string;
}
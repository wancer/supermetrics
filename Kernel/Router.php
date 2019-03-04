<?php

namespace Supermetrics\Kernel;

use Psr\Container\ContainerInterface;
use Supermetrics\Kernel\Abstraction\ConfigInterface;
use Supermetrics\Kernel\Abstraction\RouterInterface;
use Supermetrics\Kernel\Exception\RouterException;

/**
 * Class Router
 */
class Router implements RouterInterface
{
    /**
     * @var mixed|config.route
     */
    private $config;

    /**
     * Router constructor.
     *
     * @param ConfigInterface $config
     *
     * @throws Exception\ConfigException
     */
    public function __construct(ConfigInterface $config)
    {
        $this->config = $config->get('route');
    }

    /**
     * @param string $route
     *
     * @return bool
     */
    public function matchRoute(string $route): bool
    {
        return array_key_exists($route, $this->config);
    }

    /**
     * @param string $route
     *
     * @return string
     * @throws RouterException
     */
    public function getControllerClass(string $route): string
    {
        if (!$this->matchRoute($route))
        {
            throw new RouterException('Path not found');
        }

        return $this->config[$route]['controller'];
    }

    /**
     * @param string $route
     *
     * @return string
     */
    public function getControllerMethod(string $route): string
    {
        return $this->config[$route]['action'];
    }
}
<?php

namespace Supermetrics\Kernel;

use DI\ContainerBuilder;
use GuzzleHttp\Psr7\Response;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Supermetrics\Kernel\Abstraction\ConfigInterface;
use Supermetrics\Kernel\Abstraction\RouterInterface;
use function GuzzleHttp\Psr7\stream_for;

/**
 * Class Kernel
 */
class Kernel
{
    /**
     * @var ContainerInterface
     */
    private $container;

    /**
     * Kernel constructor.
     *
     * @param string $configDirectory
     *
     * @throws \Exception
     */
    public function __construct(string $configDirectory)
    {
        $this->container = (new ContainerBuilder())
            ->useAutowiring(true)
            ->useAnnotations(false)
            ->addDefinitions($configDirectory . DS . 'dependency_injection.php')
            ->build();

        /* @var Config $config*/
        $config = $this->container->get(ConfigInterface::class);
        $config->getDirectoryConfigs($configDirectory);
    }

    /**
     * @param RequestInterface $request
     */
    public function processRequest(RequestInterface $request): void
    {
        try
        {
            /* @var Router $router */
            $router = $this->container->get(RouterInterface::class);

            $requestPath = $request->getRequestTarget();

            $controllerClass = $router->getControllerClass($requestPath);
            $controller = $this->container->get($controllerClass);

            $method = $router->getControllerMethod($requestPath);

            /* @var ResponseInterface $response*/
            $response = $controller->$method($request);
        }
        catch (\Throwable $e)
        {
            // Returning errors in JSON.
            $body = json_encode([
                'code' => $e->getCode(),
                'error' => $e->getMessage(),
            ]);

            $response = (new Response())->withBody(stream_for($body));
        }

        $headers = $response->getHeaders();
        foreach ($headers as $header => $value)
        {
            header($header . ':' . implode(',', $value));
        }

        echo $response->getBody()->getContents();
    }
}
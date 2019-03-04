<?php

namespace Supermetrics\Kernel\Abstraction;

use GuzzleHttp\Psr7\Response;
use function GuzzleHttp\Psr7\stream_for;
use Psr\Http\Message\ResponseInterface;

/**
 * Class AbstractController
 */
class AbstractController
{
    /**
     * @param $output
     * @param int $httpStatus
     *
     * @return ResponseInterface
     */
    public function jsonResponse($output, int $httpStatus = 200): ResponseInterface
    {
        $body = json_encode($output);

        return new Response($httpStatus, ['Content-Type' => 'application/json'], stream_for($body));
    }
}
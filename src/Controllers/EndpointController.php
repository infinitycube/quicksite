<?php

/**
 * This class will handle default /api route
 */

declare(strict_types=1);

namespace App\Controllers;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Container\ContainerInterface;

class EndpointController
{

    protected $container;

    // constructor receives container instance
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    public function info(Request $request, Response $response, $args)
    {
        $response->getBody()->write(json_encode(["data" => "Welcome to API End point, Please refer the manual for information"], JSON_PRETTY_PRINT));
        return $response->withHeader('Content-Type', 'application/json')->withHeader('Access-Control-Allow-Origin', '*');
    }
}

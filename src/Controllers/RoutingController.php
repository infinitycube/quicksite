<?php

declare(strict_types=1);

namespace App\Controllers;

use Slim\Interfaces\RouteCollectorProxyInterface as Group;
use Psr\Container\ContainerInterface;

class RoutingController
{
    protected $container;

    // constructor receives container instance
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    // All API routes should be defind inside the api function
    public function api(Group $group)
    {
        $group->get('', EndpointController::class . ':info');

        // Sub group for TODO API
        $group->group('/todos', Todo\RoutesController::class . ':routes');
    }

    // All Site routes should be defined here
    public function site(Group $group)
    {
        $group->get('/', HomeController::class . ':home');
        $group->get('/about', HomeController::class . ':about')->add($this->container->get('sessionMiddleware'));
        $group->get('/todo', HomeController::class . ':todo');
    }
}

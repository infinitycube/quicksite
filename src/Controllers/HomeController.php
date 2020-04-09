<?php

/**
 * Class handles all routes other than /api
 */

declare(strict_types=1);

namespace App\Controllers;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Container\ContainerInterface;

class HomeController
{
    protected $container;

    // constructor receives container instance
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    public function home(Request $request, Response $response, $args)
    {
        $obj = ["route" => "home"];
        return $this->container->get('view')->render($response, 'home.twig', $obj);
    }

    public function about(Request $request, Response $response, $args)
    {
        date_default_timezone_set("Asia/Dubai");
        $session = $this->container->get('session');
        $lastAccessed = ($session->exists('last')) ? date('g:ia \o\n l jS F Y', $session->get('last')) : 'Never in this session';
        $session->last = time();
        $obj = ["route" => "about", "lastAccessed" => $lastAccessed];
        return $this->container->get('view')->render($response, 'about.twig', $obj);
    }

    public function todo(Request $request, Response $response, $args)
    {
        $obj = ["route" => "todo"];
        return $this->container->get('view')->render($response, 'todo.twig', $obj);
    }
}

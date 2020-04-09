<?php

/**
 * Set Up Twig template engine to work with Slim
 * Here the Twig Renderer and TwigMiddleware is added to the container.
 */

declare(strict_types=1);

use Slim\App;
use Slim\Middleware\Session;
use Slim\Views\Twig;
use Slim\Views\TwigMiddleware;
use SlimSession\Helper;
use Twig\Loader\FilesystemLoader;

return function (App $app) {

    $container = $app->getContainer();

    // Set Twig Renderer with the name 'view', you may call it with any container instance
    // $container->get('view')->render(response, template, data) to render contents with Twig
    // Twig renderer requires the app / route have TwigMiddleware added
    $container->set('view', function () use ($container) {
        $settings = $container->get('settings')['views'];
        $loader = new FilesystemLoader($settings['path']);
        return new Twig($loader, $settings['settings']);
    });

    // Set TwigMiddleware with name 'viewMiddleware'
    // Note that TwigMiddleware is not added but set available in container
    // If a route need to render with Twig then that route need to add
    // $app->route('/view/with/twig', viewFunction)->add($container->get('viewMiddleware'))
    $container->set('viewMiddleware', function () use ($app, $container) {
        return new TwigMiddleware($container->get('view'), $app->getRouteCollector()->getRouteParser());
    });

    // Session Middleware
    // You may add this to a particular route or group or globally to the app
    // More Info: https://github.com/bryanjhv/slim-session
    $container->set('sessionMiddleware', function () use ($container) {
        return new Session($container->get('settings')['session']);
    });

    // Session Helper
    // Used for getting and setting session data.
    // You need session middleware added to use Session Helper
    // More Info: https://github.com/bryanjhv/slim-session
    $container->set('session', function () {
        return new Helper;
    });
};

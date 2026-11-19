<?php

declare(strict_types=1);

/**
 * Build the fully configured Slim App (container, providers, middlewares, routes)
 * without running it. Used by bootstrap.php and by the test suite.
 * You may not need to alter this file
 */

use Slim\App;

require_once __DIR__ . '/../vendor/autoload.php';

return (function (): App {
    // Get the created container
    $container = require __DIR__ . '/container.php';

    // Set container to create App with on AppFactory
    $appFactory = require __DIR__ . '/app.php';
    $app = $appFactory($container);

    //Add Providers
    $providers = require __DIR__ . '/providers.php';
    $providers($app);

    // Add Slim Middlewares
    $middleware = require __DIR__ . '/middlewares.php';
    $middleware($app);

    // Main routing
    $routes = require __DIR__ . '/routes.php';
    $routes($app);

    return $app;
})();

<?php

/**
 * Bootstrap the Slim App.
 * You may not need to alter this file
 */

declare(strict_types=1);

require_once __DIR__ . '/../vendor/autoload.php';

use Slim\Factory\AppFactory;

// Get the created container
$container = require __DIR__ . '/container.php';

// Set container to create App with on AppFactory
AppFactory::setContainer($container);
$app = AppFactory::create();

//Add Providers
$providers = require __DIR__ . '/providers.php';
$providers($app);

// Add Slim Middlewares
$middleware = require __DIR__ . '/middlewares.php';
$middleware($app);

// Main routing
$routes = require __DIR__ . '/routes.php';
$routes($app);

// Run the application
$app->run();

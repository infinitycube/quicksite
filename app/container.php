<?php

/**
 * Create the Container and add settings and dependencies to the Container
 */

declare(strict_types=1);


use DI\Container;
use Dotenv\Dotenv;

// Helper functions
require_once __DIR__ . '/helper.php';

// Initialize Environment Variables
// .env is optional: copy .env.example to .env to override the defaults in settings.php.
// Real environment variables (Docker, CI, hosting) always take precedence.
Dotenv::createImmutable(__DIR__ . '/../')->safeLoad();

// Create Container using PHP-DI
$container = new Container();

// Set up settings
$settings = require __DIR__ . '/settings.php';
$settings($container);

// Set up dependencies
$dependencies = require __DIR__ . '/dependencies.php';
$dependencies($container);

return $container;

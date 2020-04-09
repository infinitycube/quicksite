<?php

/**
 * Create the Container and add settings and dependencies to the Container
 */

declare(strict_types=1);


use DI\Container;

// Create Container using PHP-DI
$container = new Container();

// Set up settings
$settings = require __DIR__ . '/settings.php';
$settings($container);

// Set up dependencies
$dependencies = require __DIR__ . '/dependencies.php';
$dependencies($container);

return $container;

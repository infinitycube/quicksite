<?php

declare(strict_types=1);

use DI\Container;
use Slim\Factory\AppFactory;

return function (Container $container) {
    // Set container to create App with on AppFactory
    AppFactory::setContainer($container);
    $app = AppFactory::create();
    return $app;
};

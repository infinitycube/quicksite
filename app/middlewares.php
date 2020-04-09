<?php

declare(strict_types=1);

use Slim\App;
use Middlewares\TrailingSlash;

return function (App $app) {
    $settings = $app->getContainer()->get('settings');

    // Parse json, form data and xml
    $app->addBodyParsingMiddleware();

    // Built-in middleware for routing
    $app->addRoutingMiddleware();

    // Built-in middleware for rendering errors with helpful information
    $app->addErrorMiddleware(
        $settings['displayErrorDetails'],
        $settings['logErrors'],
        $settings['logErrorDetails']
    );

    // Slim takes middlewares as Last In First Out that means
    // The last middleware layer added is the first to be executed.
    // This TrailingSlash middleware allows routes with traling slash
    // /api/todos/ will be same as /api/todo
    $app->add(new TrailingSlash($settings['trailingSlash']));
};

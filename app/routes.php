<?php

declare(strict_types=1);

use Slim\App;

use App\Controllers\RoutingController;

return function (App $app) {

    $c = $app->getContainer();

    // All routes starts with /api/ will be routed here
    $app->group('/api', RoutingController::class . ':api');

    // The default group which will have all front end routes
    // This group will have and added middleware to handle Twig template
    // The middileware is available in the container with name 'viewMiddleware'
    // It is set in the container in /app/views.php
    $app->group('', RoutingController::class . ':site')->add($c->get('viewMiddleware'));
};

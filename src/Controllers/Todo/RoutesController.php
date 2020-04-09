<?php

declare(strict_types=1);

namespace App\Controllers\Todo;

use Slim\Interfaces\RouteCollectorProxyInterface as Group;

class RoutesController
{

    public function routes(Group $group)
    {
        /* Todo API (This are example routes) */
        $group->get('', TodoController::class . ':getTodoList');
        $group->post('', TodoController::class . ':setTask');
        $group->post('/status', TodoController::class . ':toggleTask');
        $group->delete('', TodoController::class . ':removeTask');
    }
}

<?php

declare(strict_types=1);

use DI\Container;
use Monolog\Level;

return function (Container $container) {
    // Global Settings Object
    $container->set('settings', function () {

        $is_production = env('ENVIRONMENT', 'development') == 'production';
        $view_cache = env('VIEW_CACHE', false) ? base_path(env('VIEW_CACHE', false)) : false;
        return [
            'mainRoute' => env('MAIN_ROUTE', ''),
            'apiRoute' => env('API_ROUTE', '/api'),
            'trailingSlash' => filter_var(env('TRAILING_SLASH', false), FILTER_VALIDATE_BOOLEAN),
            'displayErrorDetails' => $is_production ? false : true,
            'logErrorDetails' => filter_var(env('LOG_ERRORDETAILS', false), FILTER_VALIDATE_BOOLEAN),
            'logErrors' => filter_var(env('LOG_ERRORS', false), FILTER_VALIDATE_BOOLEAN),
            'logger' => [
                'name' => env('LOGGER_NAME', 'quick-site'),
                'path' => isset($_ENV['docker']) ? 'php://stdout' : base_path(env('LOGGER_PATH', 'logs/app.log')),
                'level' => Level::Debug,
            ],
            'views' => [
                'path' => base_path(env('VIEWS_PATH', 'src/Views')),
                'settings' => ['cache' => $view_cache],
            ],
            'session' => [
                'name' => env('SESSION_NAME', 'quicksite_session'),
                'autorefresh' => filter_var(env('SESSION_AUTO_REFRESH', true), FILTER_VALIDATE_BOOLEAN),
                'lifetime' => env('SESSION_LIFE', '30 minutes')
            ],
            'db' => [
                'driver' => env('DB_DRIVER', 'pdo_mysql'),
                'host' => env('DB_HOST', 'db'),
                'dbname' => env('DB_NAME', 'quick_site'),
                'port' => (int) env('DB_PORT', 3306),
                'user' => env('DB_USER', 'user'),
                'password' => env('DB_PASSWORD', 'secret'),
                'charset' => env('DB_CHARSET', 'utf8mb4'),
                'collation' => env('DB_COLLATION', 'utf8mb4_unicode_ci'),
            ],
            'doctrine' => [
                'entities' => [base_path(env('DOCTRINE_ENTITY_DIRECTORY', 'src/Entity'))],
                'entityNamespace' => env('DOCTRINE_ENTITY_NAMESPACE', 'App\Entity'),
                'isDevMode' => $is_production ? false : true,
            ]
        ];
    });
};

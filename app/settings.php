<?php

declare(strict_types=1);

use DI\Container;
use Monolog\Logger;

return function (Container $container) {
    // Global Settings Object
    $container->set('settings', function () {
        return [
            'displayErrorDetails' => true, // Should be set to false in production
            'logErrorDetails' => false,
            'logErrors' => false,
            'trailingSlash' => false,
            'logger' => [
                'name' => 'slim-app',
                'path' => isset($_ENV['docker']) ? 'php://stdout' : __DIR__ . '/../logs/app.log',
                'level' => Logger::DEBUG,
            ],
            'views' => [
                'path' => __DIR__ . '/../src/Views',
                'settings' => ['cache' => false],
            ],
            'session' => [
                'name' => 'slim_session',
                'autorefresh' => true,
                'lifetime' => '30 minutes'
            ],
            'db' => [
                'driver' => 'pdo_mysql',
                'host' => 'dbserver', // Use 127.0.0.1 in case you use without docker
                'dbname' => 'quick_site',
                'port' => 3306,
                'user' => 'user',
                'password' => 'secret',
                'charset' => 'utf8mb4',
                'collation' => 'utf8mb4_unicode_ci',
                'driverOptions' => [
                    // Turn off persistent connections
                    PDO::ATTR_PERSISTENT => false,
                    // Enable exceptions
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    // Emulate prepared statements
                    PDO::ATTR_EMULATE_PREPARES => true,
                    // Set default fetch mode to array
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                    // Set character set
                    PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8mb4 COLLATE utf8mb4_unicode_ci'
                ],
            ],
            'doctrine' => [
                'entities' => [__DIR__ . '/../src/Entity'],
                'entityNamespace' => 'App\Entity',
                'isDevMode' => true, // Should be set to false in production
            ]
        ];
    });
};

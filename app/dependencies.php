<?php

/**
 * This file have all the injected dependencies.
 * If you need to add any dependencies for your app
 * you may add it to the container same way as below
 */

declare(strict_types=1);

use DI\Container;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\DriverManager;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\ORMSetup;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use Monolog\Processor\UidProcessor;
use Psr\Container\ContainerInterface;
use Psr\Log\LoggerInterface;

return function (Container $container) {

    $settings = $container->get('settings');

    // Logger
    $container->set(
        LoggerInterface::class,
        function (ContainerInterface $c) use ($settings) {

            $loggerSettings = $settings['logger'];
            $logger = new Logger($loggerSettings['name']);

            $processor = new UidProcessor();
            $logger->pushProcessor($processor);

            $handler = new StreamHandler($loggerSettings['path'], $loggerSettings['level']);
            $logger->pushHandler($handler);

            return $logger;
        }
    );

    // DB Connection (lazy: no connection is opened until the first query)
    $container->set(
        Connection::class,
        function (ContainerInterface $c) use ($settings) {
            return DriverManager::getConnection($settings['db']);
        }
    );

    // Doctrine EntityManager (entities are mapped with PHP attributes, see src/Entity)
    $container->set(
        EntityManagerInterface::class,
        function (ContainerInterface $c) use ($settings) {
            $config = ORMSetup::createAttributeMetadataConfiguration(
                $settings['doctrine']['entities'],
                $settings['doctrine']['isDevMode']
            );
            // PHP 8.4 native lazy objects for Doctrine proxies
            $config->enableNativeLazyObjects(true);
            return new EntityManager($c->get(Connection::class), $config);
        }
    );
    $container->set(EntityManager::class, \DI\get(EntityManagerInterface::class));

    // PDO Connection
    $container->set(
        PDO::class,
        function (ContainerInterface $c) {
            return $c->get(Connection::class)->getNativeConnection();
        }
    );
};

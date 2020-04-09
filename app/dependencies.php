<?php

/**
 * This file have all the injected dependencies.
 * If you need to add any dependencies for your app
 * you may add it to the container same way as below
 */

declare(strict_types=1);

use DI\Container;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use Monolog\Processor\UidProcessor;
use Doctrine\DBAL\Configuration as DoctrineConfiguration;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\DriverManager;
use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\EntityManager;
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

    // DB Connection
    $container->set(
        Connection::class,
        function (ContainerInterface $c) use ($settings) {
            $config = new DoctrineConfiguration();
            $connectionParams = $settings['db'];
            return DriverManager::getConnection($connectionParams, $config);
        }
    );

    // Doctrine EntityManager
    $container->set(
        EntityManager::class,
        function (ContainerInterface $c) use ($settings) {
            $config = Setup::createAnnotationMetadataConfiguration($settings['doctrine']['entities'], $settings['doctrine']['isDevMode'], null, null, false);
            $config->addEntityNamespace('', $settings['doctrine']['entityNamespace']);
            return EntityManager::create($settings['db'], $config);
        }
    );

    // PDO Connection
    $container->set(
        PDO::class,
        function (ContainerInterface $c) {
            return $c->get(Connection::class)->getWrappedConnection();
        }
    );
};

<?php

/**
 * WARNING
 * -------
 * This file is required for running Doctrine Migrations command line tools
 * (./vendor/bin/doctrine-migrations). Do not remove or modify this file
 * unless you are sure of what you are doing.
 */

declare(strict_types=1);

require __DIR__ . '/vendor/autoload.php';

use Doctrine\Migrations\Configuration\EntityManager\ExistingEntityManager;
use Doctrine\Migrations\Configuration\Migration\JsonFile;
use Doctrine\Migrations\DependencyFactory;
use Doctrine\ORM\EntityManagerInterface;

$container = require __DIR__ . '/app/container.php';

return DependencyFactory::fromEntityManager(
    new JsonFile(__DIR__ . '/migrations.json'),
    new ExistingEntityManager($container->get(EntityManagerInterface::class))
);

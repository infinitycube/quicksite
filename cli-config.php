<?php

/**
 * WARNING
 * -------
 * This file is required for running Doctrine command line tools
 * Do not remove or modify this file unless you are sure of what
 * you are doing. 
 */

declare(strict_types=1);

require __DIR__ . '/vendor/autoload.php';

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Tools\Console\ConsoleRunner;

$container = require __DIR__ . '/app/container.php';

$entityManager = $container->get(EntityManager::class);

return ConsoleRunner::createHelperSet($entityManager);

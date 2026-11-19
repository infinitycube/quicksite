<?php

declare(strict_types=1);

use Cli\Command\MakeMigrationCommand;
use Cli\Command\MakeMigrationDiffCommand;
use Symfony\Component\Console\Application;

$container = require __DIR__ . '/container.php';

$appFactory = require __DIR__ . '/app.php';

$app = $appFactory($container);

$console = new Application('QuickSite Console', '1.2.0');

$migrating =  new MakeMigrationCommand();

$migrating->setup($app, $console);

$console->addCommand($migrating);
$console->addCommand(new MakeMigrationDiffCommand());

return $console;

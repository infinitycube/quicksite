<?php

declare(strict_types=1);

namespace Cli\Command;

class MakeMigrationDiffCommand extends Command
{
    protected $name = 'make:migrationdiff';
    protected $help = 'Generate a migration from the difference between your entities and the database';
    protected $description = 'Make or scaffolded new migration for our database';


    public function handler()
    {
        $command = "./vendor/bin/doctrine-migrations diff";

        shell_exec($command);

        $this->info("Done");
    }
}

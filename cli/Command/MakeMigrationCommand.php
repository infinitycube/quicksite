<?php

declare(strict_types=1);

namespace Cli\Command;

class MakeMigrationCommand extends Command
{
    protected $name = 'make:migration';
    protected $help = 'Generate a new migration file';
    protected $description = 'Make or scaffolded new migration for database';


    public function handler()
    {
        $command = "./vendor/bin/doctrine-migrations generate";

        shell_exec($command);

        $this->info("Done");
    }
}

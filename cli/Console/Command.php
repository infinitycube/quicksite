<?php

declare(strict_types=1);

namespace Cli\Console;

use Symfony\Component\Console\Input\InputArgument as Arg;

class Command extends Console
{
    protected $name = 'command:add-signature';
    protected $help = 'Add command help info';
    protected $description = 'Add command description information';

    protected function require(string $description = '')
    {
        return [Arg::REQUIRED, $description];
    }

    protected function array(string $description = '', array $default = [])
    {
        return [Arg::IS_ARRAY, $description, $default];
    }

    protected function optional(string $description = '', bool $default = false)
    {
        return $default
            ? [Arg::OPTIONAL, $description, $default]
            : [Arg::OPTIONAL, $description];
    }

    protected function arguments()
    {
        return [
            'name' => ['array', 'of', 'options']
            // Add Command Arguments
        ];
    }

    protected function configure(): void
    {
        $this->setName($this->name)
            ->setHelp($this->help)
            ->setDescription($this->description);

        collect($this->arguments())->each(
            fn ($options, $name) => $this->addArgument($name, ...$options)
        );

        if (method_exists($this, 'afterConfiguration')) {
            $this->afterConfiguration();
        }
    }

    public function handler()
    {
        // Handle Command
    }
}

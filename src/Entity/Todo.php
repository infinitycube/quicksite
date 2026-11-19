<?php

declare(strict_types=1);

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: 'todo')]
class Todo
{
    #[ORM\Id]
    #[ORM\Column(type: 'integer')]
    #[ORM\GeneratedValue]
    protected ?int $id = null;

    #[ORM\Column(length: 256)]
    protected string $task = '';

    #[ORM\Column(name: 'is_complete', type: 'boolean')]
    protected bool $isComplete = false;

    /**
     * Getters and Setters
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTask(): string
    {
        return $this->task;
    }

    public function setTask(string $task): void
    {
        $this->task = $task;
    }

    public function getStatus(): bool
    {
        return $this->isComplete;
    }

    public function setStatus(bool $status): void
    {
        $this->isComplete = $status;
    }
}

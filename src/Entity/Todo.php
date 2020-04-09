<?php

declare(strict_types=1);

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/** 
 * @ORM\Entity
 * @ORM\Table (name="todo")
 */
class Todo
{
    /** 
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue
     */
    protected $id;

    /**
     * @ORM\Column(length=256)
     */
    protected $task;

    /**
     * @ORM\Column(type="boolean", name="is_complete")
     */
    protected $isComplete = false;

    /**
     * Getters and Setters
     */
    public function getId()
    {
        return $this->id;
    }

    public function getTask()
    {
        return $this->task;
    }

    public function setTask(string $task)
    {
        $this->task = $task;
    }

    public function getStatus()
    {
        return $this->isComplete;
    }

    public function setStatus(bool $status)
    {
        $this->isComplete = $status;
    }
}

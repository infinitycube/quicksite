<?php

declare(strict_types=1);

namespace Tests\Unit\Entity;

use App\Entity\Todo;
use PHPUnit\Framework\TestCase;

final class TodoTest extends TestCase
{
    public function testNewTodoIsIncompleteAndHasNoId(): void
    {
        $todo = new Todo();

        $this->assertNull($todo->getId());
        $this->assertFalse($todo->getStatus());
    }

    public function testTaskAndStatusCanBeChanged(): void
    {
        $todo = new Todo();
        $todo->setTask('Write tests');
        $todo->setStatus(true);

        $this->assertSame('Write tests', $todo->getTask());
        $this->assertTrue($todo->getStatus());
    }
}

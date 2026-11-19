<?php

declare(strict_types=1);

namespace Tests\Unit\Controllers;

use App\Controllers\Todo\TodoController;
use App\Entity\Todo;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ResponseInterface;
use Slim\Psr7\Factory\ResponseFactory;
use Slim\Psr7\Factory\ServerRequestFactory;

/**
 * Example of testing a controller in isolation: the database is replaced
 * with a mocked Doctrine EntityManager, so no MySQL server is needed.
 */
final class TodoControllerTest extends TestCase
{
    private EntityManagerInterface&MockObject $em;
    private TodoController $controller;

    protected function setUp(): void
    {
        $this->em = $this->createMock(EntityManagerInterface::class);
        $this->controller = new TodoController($this->em);
    }

    public function testGetTodoListReturnsTodosAsJson(): void
    {
        $todo = new Todo();
        $todo->setTask('Buy milk');

        $repository = $this->createStub(EntityRepository::class);
        $repository->method('findAll')->willReturn([$todo]);
        $this->em->expects($this->once())->method('getRepository')->with(Todo::class)->willReturn($repository);

        $response = $this->controller->getTodoList($this->request('GET'), $this->response(), []);

        $this->assertSame(200, $response->getStatusCode());
        $this->assertSame('application/json', $response->getHeaderLine('Content-Type'));
        $this->assertSame(
            ['data' => [['id' => null, 'text' => 'Buy milk', 'status' => false]]],
            $this->decode($response)
        );
    }

    public function testSetTaskRejectsBlankTask(): void
    {
        $this->em->expects($this->never())->method('persist');

        $response = $this->controller->setTask($this->request('POST', ['task' => '   ']), $this->response(), []);

        $this->assertSame(400, $response->getStatusCode());
        $this->assertSame('The Todo item should not be blank', $this->decode($response)['message']);
    }

    public function testSetTaskPersistsNewTodo(): void
    {
        $this->em->expects($this->once())
            ->method('persist')
            ->with($this->callback(function (Todo $todo): bool {
                // Simulate the database assigning an auto-increment id
                (new \ReflectionProperty(Todo::class, 'id'))->setValue($todo, 1);
                return $todo->getTask() === 'Ship v2';
            }));
        $this->em->expects($this->once())->method('flush');

        $response = $this->controller->setTask($this->request('POST', ['task' => 'Ship v2']), $this->response(), []);

        $this->assertSame(200, $response->getStatusCode());
        $this->assertSame('Todo item added', $this->decode($response)['message']);
    }

    public function testToggleTaskReturns404ForUnknownTodo(): void
    {
        $this->em->expects($this->once())->method('find')->with(Todo::class, 99)->willReturn(null);

        $response = $this->controller->toggleTask($this->request('POST', ['taskId' => 99]), $this->response(), []);

        $this->assertSame(404, $response->getStatusCode());
    }

    public function testToggleTaskFlipsStatus(): void
    {
        $todo = new Todo();
        $this->em->expects($this->once())->method('find')->with(Todo::class, 5)->willReturn($todo);
        $this->em->expects($this->once())->method('flush');

        $this->controller->toggleTask($this->request('POST', ['taskId' => '5']), $this->response(), []);

        $this->assertTrue($todo->getStatus());
    }

    private function request(string $method, ?array $body = null)
    {
        $request = (new ServerRequestFactory())->createServerRequest($method, '/api/todos');

        return $body === null ? $request : $request->withParsedBody($body);
    }

    private function response(): ResponseInterface
    {
        return (new ResponseFactory())->createResponse();
    }

    private function decode(ResponseInterface $response): array
    {
        return json_decode((string) $response->getBody(), true, flags: JSON_THROW_ON_ERROR);
    }
}

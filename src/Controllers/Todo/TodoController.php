<?php

declare(strict_types=1);

namespace App\Controllers\Todo;

use App\Entity\Todo;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class TodoController
{
    public function __construct(private EntityManagerInterface $em)
    {
    }

    /* Get List of Todo */
    public function getTodoList(Request $request, Response $response, array $args): Response
    {
        $data = array_map(
            fn (Todo $todo) => [
                'id' => $todo->getId(),
                'text' => $todo->getTask(),
                'status' => $todo->getStatus(),
            ],
            $this->em->getRepository(Todo::class)->findAll()
        );

        return $this->json($response, ['data' => $data]);
    }

    /* Set Task */
    public function setTask(Request $request, Response $response, array $args): Response
    {
        $task = trim((string) ($this->input($request, 'task') ?? ''));
        if ($task === '') {
            return $this->json($response, ['message' => 'The Todo item should not be blank'], 400, 'Incomplete Request');
        }

        $todo = new Todo();
        $todo->setTask($task);
        $this->em->persist($todo);
        $this->em->flush();

        if (!$todo->getId()) {
            return $this->json($response, ['message' => 'Unable to add Todo item'], 503, 'Service Unavailable');
        }

        return $this->json($response, ['message' => 'Todo item added']);
    }

    /* Toggle Complete Status */
    public function toggleTask(Request $request, Response $response, array $args): Response
    {
        $taskId = $this->input($request, 'taskId');
        if (!$taskId) {
            return $this->json($response, ['message' => 'The Todo item should not be blank'], 400, 'Incomplete Request');
        }

        $todo = $this->em->find(Todo::class, (int) $taskId);
        if (!$todo) {
            return $this->json($response, ['message' => 'Todo item not found'], 404);
        }

        $todo->setStatus(!$todo->getStatus());
        $this->em->flush();

        return $this->json($response, ['message' => 'Todo item updated']);
    }

    /* Remove a Todo Item */
    public function removeTask(Request $request, Response $response, array $args): Response
    {
        $taskId = $this->input($request, 'taskId');
        if (!$taskId) {
            return $this->json($response, ['message' => 'The Todo item should not be blank'], 400, 'Incomplete Request');
        }

        $todo = $this->em->find(Todo::class, (int) $taskId);
        if (!$todo) {
            return $this->json($response, ['message' => 'Todo item not found'], 404);
        }

        $this->em->remove($todo);
        $this->em->flush();

        return $this->json($response, ['message' => 'Todo item removed']);
    }

    /* Read a field from the parsed request body (form, JSON or XML) */
    private function input(Request $request, string $key): mixed
    {
        $body = $request->getParsedBody();

        return is_array($body) ? ($body[$key] ?? null) : null;
    }

    private function json(Response $response, array $payload, int $status = 200, string $reason = ''): Response
    {
        $response->getBody()->write(json_encode($payload, JSON_PRETTY_PRINT | JSON_THROW_ON_ERROR));

        return $response
            ->withHeader('Content-Type', 'application/json')
            ->withHeader('Access-Control-Allow-Origin', '*')
            ->withStatus($status, $reason);
    }
}

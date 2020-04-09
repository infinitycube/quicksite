<?php

declare(strict_types=1);

namespace App\Controllers\Todo;

use App\Entity\Todo;
use Doctrine\ORM\EntityManager;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use stdClass;

class TodoController
{

    private $em;

    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    /* Get List of Todo */
    public function getTodoList(Request $request, Response $response, $args)
    {
        $todos = $this->em->getRepository(':Todo')->findAll();
        $data = [];
        foreach ($todos as $todo) {
            $row = new stdClass();
            $row->id = $todo->getId();
            $row->text = $todo->getTask();
            $row->status = $todo->getStatus();
            $data[] = $row;
        }
        $response->getBody()->write(json_encode(["data" => $data], JSON_PRETTY_PRINT));
        return $response->withHeader('Content-Type', 'application/json')->withHeader('Access-Control-Allow-Origin', '*');
    }

    /* Set Task */
    public function setTask(Request $request, Response $response, $args)
    {
        $task = $request->getParsedBody()['task'];
        if ($task) {
            $todo = new Todo();
            $todo->setTask($task);
            $this->em->persist($todo);
            $this->em->flush($todo);
            if ($todo->getId()) {
                $response->getBody()->write(json_encode(["message" => "Todo item added"], JSON_PRETTY_PRINT));
                return $response->withHeader('Content-Type', 'application/json')->withHeader('Access-Control-Allow-Origin', '*');
            } else {
                $response->getBody()->write(json_encode(["message" => "Unable to add Todo item"], JSON_PRETTY_PRINT));
                return $response->withHeader('Content-Type', 'application/json')->withHeader('Access-Control-Allow-Origin', '*')->withStatus(503, "Service Unavailable");
            }
        } else {
            $response->getBody()->write(json_encode(["message" => "The Todo item should not be blank"], JSON_PRETTY_PRINT));
            return $response->withHeader('Content-Type', 'application/json')->withHeader('Access-Control-Allow-Origin', '*')->withStatus(400, "Incomplete Request");
        }
    }

    /* Toggle Complete Status */
    public function toggleTask(Request $request, Response $response, $args)
    {
        $taskId = $request->getParsedBody()['taskId'];
        if ($taskId) {
            $todo = $this->em->find(':Todo', $taskId);
            $todo->setStatus(!($todo->getStatus()));
            $this->em->persist($todo);
            $this->em->flush($todo);
            $response->getBody()->write(json_encode(["message" => "Todo item updated"], JSON_PRETTY_PRINT));
            return $response->withHeader('Content-Type', 'application/json')->withHeader('Access-Control-Allow-Origin', '*');
        } else {
            $response->getBody()->write(json_encode(["message" => "The Todo item should not be blank"], JSON_PRETTY_PRINT));
            return $response->withHeader('Content-Type', 'application/json')->withHeader('Access-Control-Allow-Origin', '*')->withStatus(400, "Incomplete Request");
        }
    }

    /* Remove a Todo Item */
    public function removeTask(Request $request, Response $response, $args)
    {
        $taskId = $request->getParsedBody()['taskId'];
        if ($taskId) {
            $todo = $this->em->find(':Todo', $taskId);
            $this->em->remove($todo);
            $stat = $this->em->getUnitOfWork()->getEntityState($todo);
            $this->em->flush($todo);
            if ($stat === 4) {
                $response->getBody()->write(json_encode(["message" => "Todo item removed"], JSON_PRETTY_PRINT));
                return $response->withHeader('Content-Type', 'application/json')->withHeader('Access-Control-Allow-Origin', '*');
            } else {
                $response->getBody()->write(json_encode(["message" => "Unable to remove Todo item"], JSON_PRETTY_PRINT));
                return $response->withHeader('Content-Type', 'application/json')->withHeader('Access-Control-Allow-Origin', '*')->withStatus(500, "Database Error");
            }
        } else {
            $response->getBody()->write(json_encode(["message" => "The Todo item should not be blank"], JSON_PRETTY_PRINT));
            return $response->withHeader('Content-Type', 'application/json')->withHeader('Access-Control-Allow-Origin', '*')->withStatus(400, "Incomplete Request");
        }
    }
}

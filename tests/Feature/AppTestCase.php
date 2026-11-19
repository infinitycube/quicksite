<?php

declare(strict_types=1);

namespace Tests\Feature;

use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ResponseInterface;
use Slim\App;
use Slim\Psr7\Factory\ServerRequestFactory;

/**
 * Base class for feature tests: boots the real Slim app (container, middlewares,
 * routes, Twig) and sends requests to it in-process, without a web server.
 */
abstract class AppTestCase extends TestCase
{
    protected App $app;

    protected function setUp(): void
    {
        $this->app = require __DIR__ . '/../../app/build.php';
    }

    protected function get(string $uri, array $headers = []): ResponseInterface
    {
        $request = (new ServerRequestFactory())->createServerRequest('GET', $uri);
        foreach ($headers as $name => $value) {
            $request = $request->withHeader($name, $value);
        }

        return $this->app->handle($request);
    }
}

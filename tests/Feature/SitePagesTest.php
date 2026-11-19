<?php

declare(strict_types=1);

namespace Tests\Feature;

final class SitePagesTest extends AppTestCase
{
    public function testHomePageRendersWithTwig(): void
    {
        $response = $this->get('/');

        $this->assertSame(200, $response->getStatusCode());
        $this->assertStringContainsString('Slim 4 Scaffolding', (string) $response->getBody());
    }

    public function testTodoPageRenders(): void
    {
        $response = $this->get('/todo');

        $this->assertSame(200, $response->getStatusCode());
    }
}

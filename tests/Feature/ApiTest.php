<?php

declare(strict_types=1);

namespace Tests\Feature;

final class ApiTest extends AppTestCase
{
    public function testApiRootReturnsWelcomeJson(): void
    {
        $response = $this->get('/api');

        $this->assertSame(200, $response->getStatusCode());
        $this->assertSame('application/json', $response->getHeaderLine('Content-Type'));
        $this->assertSame('*', $response->getHeaderLine('Access-Control-Allow-Origin'));
        $this->assertStringContainsString('Welcome to API End point', (string) $response->getBody());
    }

    public function testApiRootAcceptsTrailingSlash(): void
    {
        $response = $this->get('/api/');

        $this->assertContains($response->getStatusCode(), [200, 301], 'TrailingSlash middleware should handle /api/');
    }

    public function testUnknownRouteReturns404(): void
    {
        $response = $this->get('/api/does-not-exist', ['Accept' => 'application/json']);

        $this->assertSame(404, $response->getStatusCode());
    }
}

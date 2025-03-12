<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use Illuminate\Http\Response;
use GuzzleHttp\Client;

class SwaggerTest extends TestCase
{
    /**
     * A basic test example.
     */
    public function testPing(): void
    {
        $client = new Client();
        $response = $client->request(
            method: 'HEAD',
            uri: 'https://unpkg.com/swagger-ui-dist@latest/swagger-ui.css'
        );

        $this->assertEquals(Response::HTTP_OK, $response->getStatusCode());
    }
}

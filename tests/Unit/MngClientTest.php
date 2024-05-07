<?php

declare(strict_types=1);

namespace H22k\MngKargo\Test\Unit;

use Generator;
use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use H22k\MngKargo\Http\Payload;
use H22k\MngKargo\MngClient;
use H22k\MngKargo\Test\MngTestCase;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;

#[CoversClass(MngClient::class)]
class MngClientTest extends MngTestCase
{
    public static function successResponseDataProvider(): Generator
    {
        yield 'Success Response 200' => [
            'response' => new Response(200, ['X-Foo' => 'Bar'], 'Hello, World'),
            'expected' => [
                'status' => 200,
                'headers' => ['X-Foo' => ['Bar']],
                'body' => 'Hello, World',
            ],
        ];

        yield 'Success Response 201' => [
            'response' => new Response(201, ['X-Foo' => 'Bar'], 'Hello, World'),
            'expected' => [
                'status' => 201,
                'headers' => ['X-Foo' => ['Bar']],
                'body' => 'Hello, World',
            ],
        ];

        yield 'Success Response 204' => [
            'response' => new Response(204, ['X-Foo' => 'Bar'], ''),
            'expected' => [
                'status' => 204,
                'headers' => ['X-Foo' => ['Bar']],
                'body' => '',
            ],
        ];
    }

    #[DataProvider('successResponseDataProvider')]
    public function testGetSuccessResponse(Response $response, array $expected): void
    {
        $mockHandler = new MockHandler([
            $response,
        ]);

        $mockClient = new Client(['handler' => HandlerStack::create($mockHandler)]);
        $mngClient = new MngClient($mockClient, 'API_KEY', 'API_SECRET', 'PASS', 'CLIENT_NUMBER');

        $result = $mngClient->get(new Payload('test'));

        $this->assertSame($response, $result);
        $this->assertSame($expected['status'], $result->getStatusCode());
        $this->assertSame($expected['headers'], $result->getHeaders());
        $this->assertSame($expected['body'], $result->getBody()->getContents());
    }

    #[DataProvider('successResponseDataProvider')]
    public function testPostSuccessResponse(Response $response, array $expected): void
    {
        $mockHandler = new MockHandler([
            $response,
        ]);

        $mockClient = new Client(['handler' => HandlerStack::create($mockHandler)]);
        $mngClient = new MngClient($mockClient, 'API_KEY', 'API_SECRET', 'PASS', 'CLIENT_NUMBER');

        $result = $mngClient->post(new Payload('test'));

        $this->assertSame($response, $result);
        $this->assertSame($expected['status'], $result->getStatusCode());
        $this->assertSame($expected['headers'], $result->getHeaders());
        $this->assertSame($expected['body'], $result->getBody()->getContents());
    }

    #[DataProvider('successResponseDataProvider')]
    public function testPutSuccessResponse(Response $response, array $expected): void
    {
        $mockHandler = new MockHandler([
            $response,
        ]);

        $mockClient = new Client(['handler' => HandlerStack::create($mockHandler)]);
        $mngClient = new MngClient($mockClient, 'API_KEY', 'API_SECRET', 'PASS', 'CLIENT_NUMBER');

        $result = $mngClient->put(new Payload('test'));

        $this->assertSame($response, $result);
        $this->assertSame($expected['status'], $result->getStatusCode());
        $this->assertSame($expected['headers'], $result->getHeaders());
        $this->assertSame($expected['body'], $result->getBody()->getContents());
    }

    #[DataProvider('successResponseDataProvider')]
    public function testPatchSuccessResponse(Response $response, array $expected): void
    {
        $mockHandler = new MockHandler([
            $response,
        ]);

        $mockClient = new Client(['handler' => HandlerStack::create($mockHandler)]);
        $mngClient = new MngClient($mockClient, 'API_KEY', 'API_SECRET', 'PASS', 'CLIENT_NUMBER');

        $result = $mngClient->patch(new Payload('test'));

        $this->assertSame($response, $result);
        $this->assertSame($expected['status'], $result->getStatusCode());
        $this->assertSame($expected['headers'], $result->getHeaders());
        $this->assertSame($expected['body'], $result->getBody()->getContents());
    }

    #[DataProvider('successResponseDataProvider')]
    public function testDeleteSuccessResponse(Response $response, array $expected): void
    {
        $mockHandler = new MockHandler([
            $response,
        ]);

        $mockClient = new Client(['handler' => HandlerStack::create($mockHandler)]);
        $mngClient = new MngClient($mockClient, 'API_KEY', 'API_SECRET', 'PASS', 'CLIENT_NUMBER');

        $result = $mngClient->delete(new Payload('test'));

        $this->assertSame($response, $result);
        $this->assertSame($expected['status'], $result->getStatusCode());
        $this->assertSame($expected['headers'], $result->getHeaders());
        $this->assertSame($expected['body'], $result->getBody()->getContents());
    }
}

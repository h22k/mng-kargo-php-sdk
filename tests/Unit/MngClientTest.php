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
use H22k\MngKargo\Service\LoginService;
use H22k\MngKargo\Test\MngTestCase;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use Psr\Log\LoggerInterface;

#[CoversClass(MngClient::class)]
class MngClientTest extends MngTestCase
{
    /**
     * phpcs:ignore
     * @return Generator<array{response: Response, expected: array{status: int, headers: array<string, array>, body: string}}>
     */
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

    /**
     * @return Generator<array{response: Response, autoLogin: bool, attemptLogin: bool}>
     */
    public static function unauthorizedDataProvider(): Generator
    {
        yield 'Unauthorized Response with auto login' => [
            'response' => new Response(401),
            'autoLogin' => true,
            'attemptLogin' => true,
            'loginMethodExpect' => 1
        ];

        yield 'Unauthorized Response without auto login' => [
            'response' => new Response(401),
            'autoLogin' => false,
            'attemptLogin' => false,
            'loginMethodExpect' => 0
        ];
    }

    public static function loggerTestCaseDataProvider(): Generator
    {
        yield 'Logger should be triggered 400 status' => [
            'response' => new Response(400),
            'expected' => true,
        ];

        yield 'Logger should be triggered 500 status' => [
            'response' => new Response(500),
            'expected' => true,
        ];

        yield 'Logger should not be triggered 200 status' => [
            'response' => new Response(200),
            'expected' => false,
        ];
    }

    #[DataProvider('successResponseDataProvider')]
    public function testGetSuccessResponse(Response $response, array $expected): void
    {
        $mockHandler = new MockHandler([
            $response,
        ]);

        $mockClient = new Client(['handler' => HandlerStack::create($mockHandler)]);
        $mngClient = new MngClient(
            $mockClient,
            new LoginService('CLIENT_NUMBER', 'PASS'),
            'API_KEY',
            'API_SECRET',
        );

        $result = $mngClient->get(new Payload('test'));

        $result = $result->getResponse();
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
        $mngClient = new MngClient(
            $mockClient,
            new LoginService('CLIENT_NUMBER', 'PASS'),
            'API_KEY',
            'API_SECRET',
        );

        $result = $mngClient->post(new Payload('test'));

        $result = $result->getResponse();
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
        $mngClient = new MngClient(
            $mockClient,
            new LoginService('CLIENT_NUMBER', 'PASS'),
            'API_KEY',
            'API_SECRET',
        );

        $result = $mngClient->put(new Payload('test'));

        $result = $result->getResponse();
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
        $mngClient = new MngClient(
            $mockClient,
            new LoginService('CLIENT_NUMBER', 'PASS'),
            'API_KEY',
            'API_SECRET',
        );

        $result = $mngClient->patch(new Payload('test'));

        $result = $result->getResponse();
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
        $mngClient = new MngClient(
            $mockClient,
            new LoginService('CLIENT_NUMBER', 'PASS'),
            'API_KEY',
            'API_SECRET',
        );

        $result = $mngClient->delete(new Payload('test'));

        $result = $result->getResponse();
        $this->assertSame($expected['status'], $result->getStatusCode());
        $this->assertSame($expected['headers'], $result->getHeaders());
        $this->assertSame($expected['body'], $result->getBody()->getContents());
    }

    #[DataProvider('unauthorizedDataProvider')]
    public function testAttemptLoginIfStatusIsUnauthorized(
        Response $response,
        bool $autoLogin,
        bool $attemptLogin,
        int $loginMethodExpect
    ): void {
        $isAttemptLoginCalled = false;

        $mockHandler = new MockHandler([
            $response,
            new Response(200),
        ]);

        $handler = HandlerStack::create($mockHandler);
        $mockClient = new Client(['handler' => $handler, 'http_errors' => false]);

        $loginServiceMock = $this->createMock(LoginService::class);

        $loginServiceMock->expects($this->exactly($loginMethodExpect))
            ->method('login')
            ->with($mockClient, 'API_KEY', 'API_SECRET')
            ->willReturnCallback(function () use (&$isAttemptLoginCalled) {
                $isAttemptLoginCalled = true;
                return 'NEW_TOKEN';
            });

        $mngClient = new MngClient(
            $mockClient,
            $loginServiceMock,
            'API_KEY',
            'API_SECRET',
        );

        $mngClient->setAutoLogin($autoLogin);

        $mngClient->get(new Payload('test'));

        $this->assertSame($isAttemptLoginCalled, $attemptLogin);
    }

    #[DataProvider('loggerTestCaseDataProvider')]
    public function testLoggerShouldBeTriggeredOnBadResponse(Response $response, bool $expected): void
    {
        $loggerMock = $this->createMock(LoggerInterface::class);

        $loggerMock->expects($expected ? $this->once() : $this->never())
            ->method('error')
            ->with(serialize($response))
            ->willReturnCallback(function ($response) {
                $this->assertTrue(true);
            });

        $mockHandler = new MockHandler([
            $response,
        ]);

        $mockClient = new Client(['handler' => HandlerStack::create($mockHandler), 'http_errors' => false]);
        $mngClient = new MngClient(
            $mockClient,
            new LoginService('CLIENT_NUMBER', 'PASS'),
            'API_KEY',
            'API_SECRET',
        );

        $mngClient->setLogger($loggerMock);

        $mngClient->get(new Payload('test'));
    }
}

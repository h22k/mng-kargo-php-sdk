<?php

declare(strict_types=1);

namespace H22k\MngKargo\Test;

use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use H22k\MngKargo\MngClient;
use H22k\MngKargo\Service\LoginService;
use PHPUnit\Framework\Attributes\CoversNothing;
use PHPUnit\Framework\MockObject\Exception;
use Psr\Http\Message\ResponseInterface;
use ReflectionClass;
use ReflectionException;
use RuntimeException;

#[CoversNothing]
class MngTestCase extends TestCase
{
    /**
     * @throws ReflectionException
     */
    protected function getPrivateProperty(object $object, string $propertyName): mixed
    {
        $reflection = new ReflectionClass($object);

        return $reflection->getProperty($propertyName)->getValue($object);
    }

    /**
     * @param array<ResponseInterface> $responses
     * @return MngClient
     * @throws Exception
     */
    protected function getMockMngClient(array $responses): MngClient
    {
        $loginServiceMock = $this->createMock(LoginService::class);

        return new MngClient(
            $this->getMockClient($responses),
            $loginServiceMock,
            'apiKey',
            'apiSecret'
        );
    }

    /**
     * @param array<ResponseInterface> $responses
     * @return Client
     */
    protected function getMockClient(array $responses): Client
    {
        $handlerMock = new MockHandler($responses);

        $handlerStackMock = new HandlerStack($handlerMock);

        return new Client(['handler' => $handlerStackMock, 'http_errors' => false]);
    }

    /**
     * @param int $statusCode
     * @param string|array<mixed, mixed> $body
     * @param array<string, string> $header
     * @return ResponseInterface
     */
    protected function getResponseMock(
        int $statusCode = 200,
        string|array $body = [],
        array $header = []
    ): ResponseInterface {
        if (is_array($body)) {
            $body = json_encode($body);
            if (!$body) {
                throw new RuntimeException('Failed to encode body to json');
            }
        }

        return new Response($statusCode, $header, $body);
    }
}

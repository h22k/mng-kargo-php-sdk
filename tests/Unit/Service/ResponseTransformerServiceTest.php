<?php

declare(strict_types=1);

namespace H22k\MngKargo\Test\Unit\Service;

use GuzzleHttp\Psr7\Response;
use H22k\MngKargo\Exception\InvalidJsonException;
use H22k\MngKargo\Service\ResponseTransformerService;
use H22k\MngKargo\Test\MngTestCase;
use PHPUnit\Framework\Attributes\CoversClass;
use Psr\Http\Message\StreamInterface;

#[CoversClass(ResponseTransformerService::class)]
class ResponseTransformerServiceTest extends MngTestCase
{
    public function testGetBodyWithProperJsonData(): void
    {
        $fakeResponse = ['msg' => 'fake message'];
        $streamMock = $this->createMock(StreamInterface::class);
        $streamMock->expects($this->once())
            ->method('getContents')
            ->willReturn(json_encode($fakeResponse, JSON_THROW_ON_ERROR));


        $responseMock = $this->createMock(Response::class);

        $responseMock->expects($this->once())
            ->method('getBody')
            ->willReturn($streamMock);

        $responseTransformerService = new ResponseTransformerService($responseMock);

        $this->assertSame($fakeResponse, $responseTransformerService->getBody());
        $this->assertSame($responseMock, $responseTransformerService->getResponse());
    }

    public function testGetBodyWithInvalidJsonData(): void
    {
        $streamMock = $this->createMock(StreamInterface::class);
        $streamMock->expects($this->once())
            ->method('getContents')
            ->willReturn('INVALID_JSON_DATA');


        $responseMock = $this->createMock(Response::class);

        $responseMock->expects($this->once())
            ->method('getBody')
            ->willReturn($streamMock);

        $this->expectException(InvalidJsonException::class);
        $this->expectExceptionMessage('Syntax error');

        $responseTransformerService = new ResponseTransformerService($responseMock);
        $responseTransformerService->getBody();
    }
}

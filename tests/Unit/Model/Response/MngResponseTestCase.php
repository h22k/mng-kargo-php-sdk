<?php

declare(strict_types=1);

namespace H22k\MngKargo\Test\Unit\Model\Response;

use H22k\MngKargo\Service\ResponseTransformerService;
use H22k\MngKargo\Test\MngTestCase;
use PHPUnit\Framework\MockObject\Exception;
use PHPUnit\Framework\MockObject\MockObject;

abstract class MngResponseTestCase extends MngTestCase
{
    /**
     * @param array<int, array<string, string>> $responseBody
     * @param int $getBodyMethodExpectedCount
     * @return ResponseTransformerService<mixed>|MockObject
     * @throws Exception
     */
    protected function getResponseTransformerServiceMock(
        array $responseBody,
        int $getBodyMethodExpectedCount = 1
    ): ResponseTransformerService|MockObject {
        $responseTransformerServiceMock = $this->createMock(ResponseTransformerService::class);

        $responseTransformerServiceMock->expects($this->exactly($getBodyMethodExpectedCount))
            ->method('getBody')
            ->willReturn($responseBody);

        return $responseTransformerServiceMock;
    }
}

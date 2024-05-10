<?php

declare(strict_types=1);

namespace H22k\MngKargo\Test\Unit\Exception;

use H22k\MngKargo\Exception\InvalidJsonException;
use H22k\MngKargo\Test\MngTestCase;
use PHPUnit\Framework\Attributes\CoversClass;

#[CoversClass(InvalidJsonException::class)]
class InvalidJsonExceptionTest extends MngTestCase
{
    public function testInvalidJsonException(): void
    {
        $exceptionMock = new \JsonException('Syntax error');

        $invalidJsonException = new InvalidJsonException($exceptionMock);

        $this->assertSame('Syntax error', $invalidJsonException->getMessage());
        $this->assertSame($exceptionMock, $invalidJsonException->getPrevious());
    }
}

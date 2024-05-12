<?php

declare(strict_types=1);

namespace H22k\MngKargo\Test\Unit\Http\ValueObject;

use H22k\MngKargo\Enum\ContentType;
use H22k\MngKargo\Http\ValueObject\Header;
use H22k\MngKargo\Test\TestCase;

class HeaderTest extends TestCase
{
    private Header $header;

    public function testContentType(): void
    {
        $this->header->contentType(ContentType::JSON);

        $this->assertTrue($this->header->has('Content-Type'));
        $this->assertSame(ContentType::JSON->value, $this->header->toArray()['Content-Type']);
    }

    public function testAuthorization(): void
    {
        $this->header->authorization('AUTH_TOKEN');

        $this->assertTrue($this->header->has('Authorization'));
        $this->assertSame('Bearer AUTH_TOKEN', $this->header->toArray()['Authorization']);
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->header = new Header([]);
    }
}

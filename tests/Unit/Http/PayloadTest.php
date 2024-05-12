<?php

declare(strict_types=1);

namespace H22k\MngKargo\Test\Unit\Http;

use H22k\MngKargo\Enum\ContentType;
use H22k\MngKargo\Http\Payload;
use H22k\MngKargo\Http\ValueObject\Body;
use H22k\MngKargo\Http\ValueObject\Header;
use H22k\MngKargo\Http\ValueObject\QueryParam;
use H22k\MngKargo\Test\TestCase;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\UsesClass;

#[CoversClass(Payload::class)]
#[UsesClass(Body::class)]
#[UsesClass(QueryParam::class)]
#[UsesClass(Header::class)]
class PayloadTest extends TestCase
{
    public static function dataProvider(): array
    {
        return [
            'default' => [
                'uri' => 'testing/uri',
                'bodyValue' => ['json' => 'test'],
                'queryParams' => ['queryparams' => 'test'],
                'headers' => ['test_header' => 'test']
            ]
        ];
    }

    #[DataProvider('dataProvider')]
    public function testPayload(string $uri, array $bodyValue, array $queryParams, array $headers): void
    {
        $bodyMock = new Body($bodyValue);
        $queryParamsMock = new QueryParam($queryParams);
        $headerMock = new Header($headers);

        $payload = Payload::from($uri, $bodyMock, $queryParamsMock, $headerMock);

        $this->assertSame($bodyValue, $payload->getBody());
        $this->assertSame($queryParams, $payload->getQueryParams());
        $this->assertSame($headers, $payload->getHeaders());
        $this->assertSame($uri, $payload->getUri());

        $payload->setContentType(ContentType::JSON);

        // pay attention that headers has changed.
        $headers += ['Content-Type' => ContentType::JSON->value];

        $this->assertSame($headers, $payload->getHeaders());

        $payload->setAuthorizationKey('AUTH_KEY');

        // pay attention that headers has changed again.
        $headers += ['Authorization' => 'Bearer AUTH_KEY'];

        $this->assertSame($headers, $payload->getHeaders());

        $payload->addHeader('ADD_HEADER', 'test');

        // pay attention that headers has changed again and again.
        $headers += ['ADD_HEADER' => 'test'];

        $this->assertSame($headers, $payload->getHeaders());
    }
}

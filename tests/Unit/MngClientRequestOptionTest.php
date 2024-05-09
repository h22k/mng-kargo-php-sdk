<?php

declare(strict_types=1);

namespace H22k\MngKargo\Test\Unit;

use H22k\MngKargo\Enum\ContentType;
use H22k\MngKargo\Enum\HttpMethod;
use H22k\MngKargo\Http\Payload;
use H22k\MngKargo\Http\ValueObject\Body;
use H22k\MngKargo\Http\ValueObject\Header;
use H22k\MngKargo\Http\ValueObject\QueryParam;
use H22k\MngKargo\MngClientRequestOption;
use H22k\MngKargo\Test\MngTestCase;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;

#[CoversClass(MngClientRequestOption::class)]
class MngClientRequestOptionTest extends MngTestCase
{
    public static function optionsDataProvider(): array
    {
        return [
            'get method | Should not have body even if payload has' => [
                'method' => HttpMethod::GET,
                'content' => ContentType::JSON,
                'payload' => new Payload('test', new Body(['test' => 'test'])),
                'body' => [], // empty array means there is not body and no json key in options
                'shouldHasBody' => false,
            ],
            'post method | Should have body if payload has' => [
                'method' => HttpMethod::POST,
                'content' => ContentType::JSON,
                'payload' => new Payload('test', new Body(['test' => 'test'])),
                'body' => ['test' => 'test'],
                'shouldHasBody' => true,
            ],
            'put method | Should have body if payload has' => [
                'method' => HttpMethod::PUT,
                'content' => ContentType::JSON,
                'payload' => new Payload('test', new Body(['test' => 'test'])),
                'body' => ['test' => 'test'],
                'shouldHasBody' => true,
            ],
            'patch method | Should have body if payload has' => [
                'method' => HttpMethod::PATCH,
                'content' => ContentType::JSON,
                'payload' => new Payload('test', new Body(['test' => 'test'])),
                'body' => ['test' => 'test'],
                'shouldHasBody' => true,
            ],
            'post method | Should not have body if payload has not' => [
                'method' => HttpMethod::POST,
                'content' => ContentType::JSON,
                'payload' => new Payload('test'),
                'body' => [],
                'shouldHasBody' => false,
            ],
        ];
    }

    public static function httpMethodDataProvider(): array
    {
        return [
            'get' => [
                'method' => HttpMethod::GET,
                'methodName' => 'GET'
            ],
            'post' => [
                'method' => HttpMethod::POST,
                'methodName' => 'POST'
            ],
            'put' => [
                'method' => HttpMethod::PUT,
                'methodName' => 'PUT'
            ],
            'patch' => [
                'method' => HttpMethod::PATCH,
                'methodName' => 'PATCH'
            ],
            'delete' => [
                'method' => HttpMethod::DELETE,
                'methodName' => 'DELETE'
            ],
        ];
    }

    #[DataProvider('optionsDataProvider')]
    public function testBodyInsideOptions(
        HttpMethod $httpMethod,
        ContentType $contentType,
        Payload $payload,
        array $body,
        bool $shouldHasBody,
    ): void {
        $mngClientRequestOptions = new MngClientRequestOption($httpMethod, $contentType, $payload);
        $options = $mngClientRequestOptions->getOptions();

        $this->assertIsArray($options);

        $this->assertSame($shouldHasBody, array_key_exists('json', $options));

        if (!$shouldHasBody) {
            return;
        }

        $this->assertArrayHasKey('json', $options);
        $this->assertSame($body, $options['json']);
    }

    public function testHeaderInsideOptions(): void
    {
        $mngClientRequestOptions = MngClientRequestOption::from(
            HttpMethod::GET,
            ContentType::JSON,
            new Payload('test', null, null, new Header(['test' => 'test']))
        );

        $mngClientRequestOptions->setDefaultHeader('API_KEY', 'API_SECRET', 'AUTH_TOKEN');

        $options = $mngClientRequestOptions->getOptions();

        $this->assertIsArray($options);
        $this->assertCount(1, $options);
        $this->assertArrayHasKey('headers', $options);

        $headers = $options['headers'];

        $this->assertIsArray($headers);
        $this->assertArrayHasKey('X-IBM-Client-Id', $headers);
        $this->assertArrayHasKey('X-IBM-Client-Secret', $headers);
        $this->assertArrayHasKey('Authorization', $headers);
        $this->assertArrayHasKey('test', $headers);

        $this->assertSame('API_KEY', $headers['X-IBM-Client-Id']);
        $this->assertSame('API_SECRET', $headers['X-IBM-Client-Secret']);
        $this->assertSame('Bearer AUTH_TOKEN', $headers['Authorization']);
        $this->assertSame('test', $headers['test']);
    }

    public function testQueryParamInsideOptions(): void
    {
        $mngClientRequestOptions = MngClientRequestOption::from(
            HttpMethod::GET,
            ContentType::JSON,
            new Payload('test', null, new QueryParam(['test' => 'test']))
        );

        $options = $mngClientRequestOptions->getOptions();

        $this->assertIsArray($options);
        $this->assertArrayHasKey('query', $options);

        $queryParams = $options['query'];

        $this->assertIsArray($queryParams);
        $this->assertCount(1, $queryParams);
        $this->assertArrayHasKey('test', $queryParams);
        $this->assertSame('test', $queryParams['test']);
    }

    public function testGetUriShouldSameAsPayloads(): void
    {
        $mngClientRequestOptions = MngClientRequestOption::from(
            HttpMethod::GET,
            ContentType::JSON,
            new Payload('test')
        );

        $this->assertSame('test', $mngClientRequestOptions->getUri());
    }

    #[DataProvider('httpMethodDataProvider')]
    public function testGetMethodShouldReturn(HttpMethod $httpMethod, string $methodName): void
    {
        $mngClientRequestOptions = MngClientRequestOption::from(
            $httpMethod,
            ContentType::JSON,
            new Payload('test')
        );

        $this->assertSame($methodName, $mngClientRequestOptions->getMethod());
    }
}

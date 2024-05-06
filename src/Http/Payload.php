<?php

declare(strict_types=1);

namespace H22k\MngKargo\Http;

use H22k\MngKargo\Enum\ContentType;
use H22k\MngKargo\Http\ValueObject\Body;
use H22k\MngKargo\Http\ValueObject\Header;
use H22k\MngKargo\Http\ValueObject\QueryParam;

final class Payload
{
    private Body $body;
    private QueryParam $queryParam;
    private Header $header;

    public function __construct(
        private readonly string $uri,
        ?Body $body = null,
        ?QueryParam $queryParam = null,
        ?Header $header = null
    ) {
        $this->body = $body ?? new Body([]);
        $this->queryParam = $queryParam ?? new QueryParam([]);
        $this->header = $header ?? new Header([]);
    }

    public static function from(
        string $uri,
        ?Body $body = null,
        ?QueryParam $queryParam = null,
        ?Header $header = null
    ): self {
        return new self($uri, $body, $queryParam, $header);
    }

    public function getUri(): string
    {
        return $this->uri;
    }

    public function contentType(ContentType $contentType): void
    {
        $this->header->contentType($contentType);
    }

    /**
     * @return array<string, string|int|bool>
     */
    public function getHeaders(): array
    {
        return $this->header->toArray();
    }

    /**
     * @return array<string, string|int|bool>
     */
    public function getQueryParams(): array
    {
        return $this->queryParam->toArray();
    }

    /**
     * @return array<string, string|int|bool>
     */
    public function getBody(): array
    {
        return $this->body->toArray();
    }

    public function addHeader(string $key, string|int|bool $value): self
    {
        $this->header->add($key, $value);

        return $this;
    }
}

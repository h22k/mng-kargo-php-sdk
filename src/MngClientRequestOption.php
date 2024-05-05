<?php

declare(strict_types=1);

namespace H22k\MngKargo;

use Psr\Http\Message\UriInterface;

class MngClientRequestOption
{
    public function __construct(
        private string|UriInterface $uri,
        private array $headers = [],
        private array $queryParams = [],
        private array $bodyParams = []
    ) {
    }

    public static function from(string|UriInterface $uri, array $data): self
    {
        return new self($uri, $data['headers'] ?? [], $data['query'] ?? [], $data['body'] ?? []);
    }

    public function getUri(): string|UriInterface
    {
        return $this->uri;
    }

    public function addHeader(string $key, bool|int|string $value): self
    {
        $this->headers[$key] = $value;

        return $this;
    }

    public function toArray(): array
    {
        $options = [];

        if (0 !== count($this->headers)) {
            $options['headers'] = $this->headers;
        }

        if (0 !== count($this->queryParams)) {
            $options['query'] = $this->queryParams;
        }

        if (0 !== count($this->bodyParams)) {
            $options['json'] = $this->bodyParams;
        }

        return $options;
    }

    public function getHeaders(): array
    {
        return $this->headers;
    }

    public function getQueryParams(): array
    {
        return $this->queryParams;
    }

    public function getBodyParams(): array
    {
        return $this->bodyParams;
    }
}

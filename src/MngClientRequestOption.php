<?php

declare(strict_types=1);

namespace H22k\MngKargo;

use H22k\MngKargo\Enum\ContentType;
use H22k\MngKargo\Enum\HttpMethod;
use H22k\MngKargo\Http\Payload;

/**
 * Entity pattern implementation to manage request options easier.
 */
class MngClientRequestOption
{
    public function __construct(
        private readonly HttpMethod $method,
        ContentType $contentType,
        private readonly Payload $payload
    ) {
        if ($this->shouldHasBody()) {
            $this->payload->setContentType($contentType);
        }
    }

    private function shouldHasBody(): bool
    {
        return in_array($this->method, [HttpMethod::POST, HttpMethod::PUT, HttpMethod::PATCH], true);
    }

    public static function from(HttpMethod $method, ContentType $contentType, Payload $payload): self
    {
        return new self($method, $contentType, $payload);
    }

    public function getMethod(): string
    {
        return $this->method->value;
    }

    public function getUri(): string
    {
        return $this->payload->getUri();
    }

    public function setDefaultHeader(string $apiKey, string $apiSecret, ?string $authToken): void
    {
        $this->payload->addHeader('X-IBM-Client-Id', $apiKey);
        $this->payload->addHeader('X-IBM-Client-Secret', $apiSecret);

        if (null !== $authToken) {
            $this->payload->setAuthorizationKey($authToken);
        }
    }

    /**
     * phpcs:ignore
     * @return array{json?: array<string, string|int|bool>, headers?: array<string, string|int|bool>, query?: array<string, string|int|bool>}
     */
    public function getOptions(): array
    {
        $options = [];

        if ($this->shouldHasBody() && count($this->payload->getBody()) > 0) {
            $options['json'] = $this->payload->getBody();
        }

        if (count($this->payload->getHeaders()) > 0) {
            $options['headers'] = $this->payload->getHeaders();
        }

        if (count($this->payload->getQueryParams()) > 0) {
            $options['query'] = $this->payload->getQueryParams();
        }

        return $options;
    }
}

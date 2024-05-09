<?php

declare(strict_types=1);

namespace H22k\MngKargo\Service;

use JsonException;
use PHPUnit\Util\InvalidJsonException;
use Psr\Http\Message\ResponseInterface;

/**
 * @template K
 */
class ResponseTransformerService
{
    public function __construct(private readonly ResponseInterface $response)
    {
    }

    /**
     * @return array<K>
     * @phpstan-return array<K>
     */
    public function getBody(): array
    {
        $body = $this->response->getBody()->getContents();

        try {
            $bodyAsArray = json_decode($body, true, 512, JSON_THROW_ON_ERROR);
        } catch (JsonException $e) {
            throw new InvalidJsonException($e->getMessage());
        }

        return $bodyAsArray;
    }

    public function getResponse(): ResponseInterface
    {
        return $this->response;
    }
}

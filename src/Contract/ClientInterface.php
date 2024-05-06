<?php

declare(strict_types=1);

namespace H22k\MngKargo\Contract;

use GuzzleHttp\ClientInterface as GuzzleClientInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\UriInterface;

interface ClientInterface extends GuzzleClientInterface
{
    /**
     * @param array<string, bool|int|string> $config
     */
    public function __construct(array $config = []);

    /**
     * @param array<string, bool|int|string> $options
     */
    public function get(string|UriInterface $uri, array $options = []): ResponseInterface;

    /**
     * @param array<string, bool|int|string> $options
     */
    public function head(string|UriInterface $uri, array $options = []): ResponseInterface;

    /**
     * @param array<string, bool|int|string> $options
     */
    public function put(string|UriInterface $uri, array $options = []): ResponseInterface;

    /**
     * @param array<string, bool|int|string> $options
     */
    public function post(string|UriInterface $uri, array $options = []): ResponseInterface;

    /**
     * @param array<string, bool|int|string> $options
     */
    public function delete(string|UriInterface $uri, array $options = []): ResponseInterface;

    /**
     * @param array<string, bool|int|string> $options
     */
    public function patch(string|UriInterface $uri, array $options = []): ResponseInterface;
}

<?php

declare(strict_types=1);

namespace H22k\MngKargo\Contract;

use GuzzleHttp\ClientInterface as GuzzleClientInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\UriInterface;

interface ClientInterface extends GuzzleClientInterface
{
    /**
     * @param array<string, string|int|bool> $config
     */
    public function __construct(array $config = []);

    /**
     * @param string|UriInterface $uri
     * @param array<string, string|int|bool> $options
     * @return ResponseInterface
     */
    public function get(string|UriInterface $uri, array $options = []): ResponseInterface;

    /**
     * @param string|UriInterface $uri
     * @param array<string, string|int|bool> $options
     * @return ResponseInterface
     */
    public function head(string|UriInterface $uri, array $options = []): ResponseInterface;

    /**
     * @param string|UriInterface $uri
     * @param array<string, string|int|bool> $options
     * @return ResponseInterface
     */
    public function put(string|UriInterface $uri, array $options = []): ResponseInterface;

    /**
     * @param string|UriInterface $uri
     * @param array<string, string|int|bool> $options
     * @return ResponseInterface
     */
    public function post(string|UriInterface $uri, array $options = []): ResponseInterface;

    /**
     * @param string|UriInterface $uri
     * @param array<string, string|int|bool> $options
     * @return ResponseInterface
     */
    public function delete(string|UriInterface $uri, array $options = []): ResponseInterface;

    /**
     * @param string|UriInterface $uri
     * @param array<string, string|int|bool> $options
     * @return ResponseInterface
     */
    public function patch(string|UriInterface $uri, array $options = []): ResponseInterface;
}

<?php

declare(strict_types=1);

namespace H22k\MngKargo;

use GuzzleHttp\Client;
use H22k\MngKargo\Contract\ClientInterface;
use H22k\MngKargo\Enum\HttpMethod;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\UriInterface;
use Psr\Log\LoggerInterface;

final class MngClient
{
    private bool $autoLogin = true;

    private ?LoggerInterface $logger = null;

    public function __construct(
        private readonly Client|ClientInterface $client,
        private string $apiKey,
        private string $apiSecret,
        private string $userName,
        private string $userPassword,
        private string $mngClientNumber,
    ) {
    }

    public function setAutoLogin(bool $autoLogin): self
    {
        $this->autoLogin = $autoLogin;

        return $this;
    }

    public function setLogger(?LoggerInterface $logger): self
    {
        $this->logger = $logger;

        return $this;
    }

    public function post(string|UriInterface $uri, array $data): ResponseInterface
    {
        return $this->autoLoginRequest(HttpMethod::POST, MngClientRequestOption::from($uri, $data));
    }

    private function autoLoginRequest(HttpMethod $method, MngClientRequestOption $option): ResponseInterface
    {
        $option->addHeader('Content-Type', 'application/json');
        $option->addHeader('Accept', 'application/json');
        $option->addHeader('X-IBM-Client-Secret', $this->apiSecret);
        $option->addHeader('X-IBM-Client-Id', $this->apiKey);

        $response = $this->client->request($method->value, $option->getUri(), $option->toArray());

        if ($response->getStatusCode() >= 400 && $this->autoLogin) {
            // login and put auth token into header
            if (null !== $this->logger) {
                $this->logger->error($response->getBody()->getContents());
            }

            //            $option->addHeader('Authorization', 'Bearer ' . 'hakan');
            //            $response = $closure($option->getUri(), $option->toArray());
        }

        return $response;
    }

    public function get(string|UriInterface $uri, array $data): ResponseInterface
    {
        return $this->autoLoginRequest(HttpMethod::GET, MngClientRequestOption::from($uri, $data));
    }

    public function put(string|UriInterface $uri, array $data): ResponseInterface
    {
        return $this->autoLoginRequest(HttpMethod::PUT, MngClientRequestOption::from($uri, $data));
    }

    public function delete(string|UriInterface $uri, array $data): ResponseInterface
    {
        return $this->autoLoginRequest(HttpMethod::DELETE, MngClientRequestOption::from($uri, $data));
    }

    public function patch(string|UriInterface $uri, array $data): ResponseInterface
    {
        return $this->autoLoginRequest(HttpMethod::PATCH, MngClientRequestOption::from($uri, $data));
    }
}

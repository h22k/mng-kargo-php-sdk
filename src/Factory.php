<?php

declare(strict_types=1);

namespace H22k\MngKargo;

use GuzzleHttp\Client;
use H22k\MngKargo\Contract\ClientInterface;
use H22k\MngKargo\Service\LoginService;
use Psr\Log\LoggerInterface;

class Factory
{
    private ?string $baseUrl = null;

    /**
     * @var array<string, bool|int|string>
     */
    private array $headers = [];

    private Client|ClientInterface $client;

    private bool $throwHttpExceptions = false;

    private int $httpTimeout = 0;

    private bool $debug = false;

    private bool $sslVerify = false;

    private bool $cookies = false;

    private bool $allowRedirects = false;

    private bool $autoLogin = true;

    private ?LoggerInterface $logger = null;

    public function __construct(
        private readonly string $apiKey,
        private readonly string $apiSecret,
        private readonly string $password,
        private readonly string $mngClientNumber
    ) {
    }

    public static function create(
        string $apiKey,
        string $apiSecret,
        string $password,
        string $mngClientNumber,
    ): self {
        return new self($apiKey, $apiSecret, $password, $mngClientNumber);
    }

    public function setClient(Client|ClientInterface $client): Factory
    {
        $this->client = $client;

        return $this;
    }

    public function setThrowHttpExceptions(bool $throwHttpExceptions): Factory
    {
        $this->throwHttpExceptions = $throwHttpExceptions;

        return $this;
    }

    public function setHttpTimeout(int $httpTimeout): Factory
    {
        $this->httpTimeout = $httpTimeout;

        return $this;
    }

    public function setDebug(bool $debug): Factory
    {
        $this->debug = $debug;

        return $this;
    }

    public function setSslVerify(bool $sslVerify): Factory
    {
        $this->sslVerify = $sslVerify;

        return $this;
    }

    public function setCookies(bool $cookies): Factory
    {
        $this->cookies = $cookies;

        return $this;
    }

    public function setAllowRedirects(bool $allowRedirects): Factory
    {
        $this->allowRedirects = $allowRedirects;

        return $this;
    }

    public function setBaseUrl(?string $baseUrl): Factory
    {
        $this->baseUrl = $baseUrl;

        return $this;
    }

    /**
     * @param array<string, bool|int|string> $headers
     *
     * @return $this
     */
    public function setHeaders(array $headers): Factory
    {
        $this->headers = $headers;

        return $this;
    }

    public function make(): Mng
    {
        return new Mng($this->buildMngClient());
    }

    private function buildMngClient(): MngClient
    {
        $client = $this->buildClient();
        $loginService = new LoginService($this->mngClientNumber, $this->password);

        return (new MngClient(
            $client,
            $loginService,
            $this->apiKey,
            $this->apiSecret,
        ))
            ->setAutoLogin($this->autoLogin)
            ->setLogger($this->logger);
    }

    private function buildClient(): Client|ClientInterface
    {
        if (!isset($this->client)) {
            $this->client = new Client(
                [
                    'base_uri' => $this->baseUrl,
                    'headers' => $this->headers,
                    'http_errors' => $this->throwHttpExceptions,
                    'timeout' => $this->httpTimeout,
                    'debug' => $this->debug,
                    'verify' => $this->sslVerify,
                    'cookies' => $this->cookies,
                    'allow_redirects' => $this->allowRedirects,
                ]
            );
        }

        return $this->client;
    }

    public function setLogger(?LoggerInterface $logger): Factory
    {
        $this->logger = $logger;

        return $this;
    }

    public function setAutoLogin(bool $autoLogin): Factory
    {
        $this->autoLogin = $autoLogin;

        return $this;
    }
}

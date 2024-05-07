<?php

declare(strict_types=1);

namespace H22k\MngKargo;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use H22k\MngKargo\Contract\ClientInterface;
use H22k\MngKargo\Enum\ContentType;
use H22k\MngKargo\Enum\HttpMethod;
use H22k\MngKargo\Http\Payload;
use H22k\MngKargo\Http\ValueObject\Body;
use Psr\Http\Message\ResponseInterface;
use Psr\Log\LoggerInterface;

final class MngClient
{
    private const UNAUTHORIZED_STATUS_CODE = 401;

    private bool $autoLogin = true;

    private ?LoggerInterface $logger = null;

    private ?string $authToken = null;

    public function __construct(
        private readonly Client|ClientInterface $client,
        private string $apiKey,
        private string $apiSecret,
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

    public function get(Payload $payload): ResponseInterface
    {
        return $this->autoLoginRequest(
            MngClientRequestOption::from(HttpMethod::GET, ContentType::JSON, $payload)
        );
    }

    /**
     * @param MngClientRequestOption $option
     * @return ResponseInterface
     * @throws GuzzleException
     */
    private function autoLoginRequest(MngClientRequestOption $option): ResponseInterface
    {
        $response = $this->send($option);

        if ($this->autoLogin && $response->getStatusCode() === self::UNAUTHORIZED_STATUS_CODE) {
            // inside of this method, we set the authToken so that the next request will use the new token
            // if we cant login with this method, we throw an exception
            $this->doLogin();

            // retry the request with the new token just been created
            $response = $this->send($option);
        }

        return $response;
    }

    /**
     * @param MngClientRequestOption $option
     * @return ResponseInterface
     * @throws GuzzleException
     */
    private function send(MngClientRequestOption $option): ResponseInterface
    {
        $option->setDefaultHeader($this->apiKey, $this->apiSecret, $this->authToken);

        $response = $this->client->request($option->getMethod(), $option->getUri(), $option->getOptions());

        if ($response->getStatusCode() >= 400) {
            $this->logger?->error(serialize($response));
        }

        return $response;
    }

    private function doLogin(): void
    {
        $payload = Payload::from('token', new Body([
            'customerNumber' => $this->mngClientNumber,
            'password' => $this->userPassword,
            'identityType' => 1,
        ]));

        $option = MngClientRequestOption::from(HttpMethod::POST, ContentType::JSON, $payload);

        $response = $this->send($option);

        if ($response->getStatusCode() >= 400) {
            throw new \RuntimeException('Login failed');
        }

        $this->authToken = json_decode($response->getBody()->getContents(), true)['jwt']; //TODO:: make here better
    }

    public function put(Payload $payload): ResponseInterface
    {
        return $this->autoLoginRequest(
            MngClientRequestOption::from(HttpMethod::PUT, ContentType::JSON, $payload)
        );
    }

    public function delete(Payload $payload): ResponseInterface
    {
        return $this->autoLoginRequest(
            MngClientRequestOption::from(HttpMethod::DELETE, ContentType::JSON, $payload)
        );
    }

    public function patch(Payload $payload): ResponseInterface
    {
        return $this->autoLoginRequest(
            MngClientRequestOption::from(HttpMethod::PATCH, ContentType::JSON, $payload)
        );
    }

    public function post(Payload $payload): ResponseInterface
    {
        return $this->autoLoginRequest(
            MngClientRequestOption::from(HttpMethod::POST, ContentType::JSON, $payload)
        );
    }
}

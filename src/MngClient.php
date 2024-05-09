<?php

declare(strict_types=1);

namespace H22k\MngKargo;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use H22k\MngKargo\Contract\ClientInterface;
use H22k\MngKargo\Enum\ContentType;
use H22k\MngKargo\Enum\HttpMethod;
use H22k\MngKargo\Http\Payload;
use H22k\MngKargo\Service\LoginService;
use H22k\MngKargo\Service\ResponseTransformerService;
use Psr\Http\Message\ResponseInterface;
use Psr\Log\LoggerInterface;

/**
 * Wrapper client class to centralize the request submission process.
 */
final class MngClient
{
    private const UNAUTHORIZED_STATUS_CODE = 401;

    private ?LoggerInterface $logger = null;

    private bool $autoLogin = true;

    private ?string $authToken = null;

    public function __construct(
        private readonly Client|ClientInterface $client,
        private LoginService $loginService,
        private string $apiKey,
        private string $apiSecret,
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

    /**
     * @param Payload $payload
     * @return ResponseTransformerService<mixed>
     * @throws GuzzleException
     */
    public function get(Payload $payload): ResponseTransformerService
    {
        return $this->autoLoginRequest(
            MngClientRequestOption::from(HttpMethod::GET, ContentType::JSON, $payload),
        );
    }


    /**
     * @param MngClientRequestOption $option
     * @return ResponseTransformerService<mixed>
     * @throws GuzzleException
     */
    private function autoLoginRequest(MngClientRequestOption $option): ResponseTransformerService
    {
        $response = $this->send($option);

        if ($this->autoLogin && $response->getStatusCode() === self::UNAUTHORIZED_STATUS_CODE) {
            // inside of this method, we set the authToken so that the next request will use the new token
            // if we cant login with this method, we throw an exception
            $this->authToken = $this->loginService->login($this->client, $this->apiKey, $this->apiSecret);

            // retry the request with the new token just been created
            $response = $this->send($option);
        }

        return new ResponseTransformerService($response);
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

    /**
     * @param Payload $payload
     * @return ResponseTransformerService<mixed>
     * @throws GuzzleException
     */
    public function put(Payload $payload): ResponseTransformerService
    {
        return $this->autoLoginRequest(
            MngClientRequestOption::from(HttpMethod::PUT, ContentType::JSON, $payload)
        );
    }

    /**
     * @param Payload $payload
     * @return ResponseTransformerService<mixed>
     * @throws GuzzleException
     */
    public function delete(Payload $payload): ResponseTransformerService
    {
        return $this->autoLoginRequest(
            MngClientRequestOption::from(HttpMethod::DELETE, ContentType::JSON, $payload)
        );
    }

    /**
     * @param Payload $payload
     * @return ResponseTransformerService<mixed>
     * @throws GuzzleException
     */
    public function patch(Payload $payload): ResponseTransformerService
    {
        return $this->autoLoginRequest(
            MngClientRequestOption::from(HttpMethod::PATCH, ContentType::JSON, $payload)
        );
    }

    /**
     * @param Payload $payload
     * @return ResponseTransformerService<mixed>
     * @throws GuzzleException
     */
    public function post(Payload $payload): ResponseTransformerService
    {
        return $this->autoLoginRequest(
            MngClientRequestOption::from(HttpMethod::POST, ContentType::JSON, $payload)
        );
    }
}

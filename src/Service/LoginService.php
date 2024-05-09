<?php

declare(strict_types=1);

namespace H22k\MngKargo\Service;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use H22k\MngKargo\Contract\ClientInterface;

/**
 * This class is responsible for login to MNG API service.
 *
 * @see https://sandbox.mngkargo.com.tr/tr/product/2136/api/2129#/IdentityAPI_10/operation/%2Ftoken/post
 */
class LoginService
{
    private const LOGIN_URI = 'token';

    public function __construct(
        private readonly string $mngClientNumber,
        private readonly string $mngPassword,
    ) {
    }

    /**
     * Get JWT token from MNG API service to use other services.
     *
     * @throws GuzzleException
     */
    public function login(Client|ClientInterface $client, string $apiKey, string $apiSecret): string
    {
        $response = $client->post(
            self::LOGIN_URI,
            [
                'json' => [ // request body
                    'customerNumber' => $this->mngClientNumber,
                    'password' => $this->mngPassword,
                    'identityType' => 1
                ],
                'headers' => [ // request header
                    'X-IBM-Client-Id' => $apiKey,
                    'X-IBM-Client-Secret' => $apiSecret,
                    'Content-Type' => 'application/json',
                ],
            ]
        );

        return $response->getBody()->getContents();
    }
}

<?php

declare(strict_types=1);

namespace H22k\MngKargo\Test\Unit\Service;

use GuzzleHttp\Psr7\Response;
use H22k\MngKargo\Contract\ClientInterface;
use H22k\MngKargo\Service\LoginService;
use H22k\MngKargo\Test\MngTestCase;

class LoginServiceTest extends MngTestCase
{
    private LoginService $loginService;

    public function testLoginSendsPostRequestWithBodyAndHeader(): void
    {
        $clientMock = $this->createMock(ClientInterface::class);

        $clientMock->expects($this->once())
            ->method('post')
            ->with('token', [
                'json' => [
                    'customerNumber' => 'clientNumber',
                    'password' => 'password',
                    'identityType' => 1
                ],
                'headers' => [
                    'X-IBM-Client-Id' => 'apiKey',
                    'X-IBM-Client-Secret' => 'apiSecret',
                    'Content-Type' => 'application/json',
                ],
            ])
            ->willReturnCallback(function () {
                return new Response(200, body: json_encode(['token' => 'jwtToken']));
            });

        $responseAsJson = $this->loginService->login($clientMock, 'apiKey', 'apiSecret');
        $responseAsArray = json_decode($responseAsJson, true);

        $this->assertArrayHasKey('token', $responseAsArray);
        $this->assertEquals('jwtToken', $responseAsArray['token']);
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->loginService = new LoginService('clientNumber', 'password');
    }
}

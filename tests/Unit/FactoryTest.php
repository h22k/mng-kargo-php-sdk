<?php

declare(strict_types=1);

namespace H22k\MngKargo\Test\Unit;

use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Uri;
use H22k\MngKargo\Contract\ClientInterface;
use H22k\MngKargo\Factory;
use H22k\MngKargo\Mng;
use H22k\MngKargo\MngClient;
use H22k\MngKargo\Test\MngTestCase;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\UsesClass;
use Psr\Log\LoggerInterface;

#[CoversClass(Factory::class)]
#[UsesClass(MngClient::class)]
#[UsesClass(Mng::class)]
class FactoryTest extends MngTestCase
{
    private Factory $factory;

    public function testHasMethods(): void
    {
        $this->assertTrue(method_exists($this->factory, 'setLogger'));
        $this->assertTrue(method_exists($this->factory, 'setHttpTimeout'));
        $this->assertTrue(method_exists($this->factory, 'setCookies'));
        $this->assertTrue(method_exists($this->factory, 'setDebug'));
        $this->assertTrue(method_exists($this->factory, 'setSslVerify'));
        $this->assertTrue(method_exists($this->factory, 'setAutoLogin'));
        $this->assertTrue(method_exists($this->factory, 'setBaseUrl'));
        $this->assertTrue(method_exists($this->factory, 'setClient'));
        $this->assertTrue(method_exists($this->factory, 'setAllowRedirects'));
        $this->assertTrue(method_exists($this->factory, 'setHttpTimeout'));
        $this->assertTrue(method_exists($this->factory, 'setThrowHttpExceptions'));
        $this->assertTrue(method_exists($this->factory, 'setHeaders'));
    }

    public function testCreateReturnsFactoryInstance(): void
    {
        $factory = Factory::create(
            'API_KEY',
            'API_SECRET',
            'USERNAME',
            'PASS',
            'CLIENT_NUMBER'
        );

        $this->assertInstanceOf(Factory::class, $factory);

        $this->assertEquals('API_KEY', $this->getPrivateProperty($factory, 'apiKey'));
        $this->assertEquals('API_SECRET', $this->getPrivateProperty($factory, 'apiSecret'));
        $this->assertEquals('USERNAME', $this->getPrivateProperty($factory, 'username'));
        $this->assertEquals('PASS', $this->getPrivateProperty($factory, 'password'));
        $this->assertEquals('CLIENT_NUMBER', $this->getPrivateProperty($factory, 'mngClientNumber'));
    }

    public function testMakeReturnsMngInstance(): void
    {
        $this->assertInstanceOf(Mng::class, $this->factory->make());
    }

    public function testGuzzleClientConfiguration(): void
    {
        $this->factory
            ->setHeaders([])
            ->setThrowHttpExceptions(false)
            ->setSslVerify(true)
            ->setDebug(false)
            ->setBaseUrl('https://example.com')
            ->setHttpTimeout(300)
            ->setAllowRedirects(false)
            ->setCookies(true);

        $mng = $this->factory->make();
        $this->assertInstanceOf(Mng::class, $mng);

        $mngClient = $this->getPrivateProperty($mng, 'client');
        $this->assertInstanceOf(MngClient::class, $mngClient);

        $guzzleClient = $this->getPrivateProperty($mngClient, 'client');
        $this->assertInstanceOf(Client::class, $guzzleClient);

        $guzzleClientConfig = $this->getPrivateProperty($guzzleClient, 'config');
        $this->assertIsArray($guzzleClientConfig);

        $this->assertArrayHasKey('headers', $guzzleClientConfig);
        $this->assertEquals('GuzzleHttp/7', $guzzleClientConfig['headers']['User-Agent']);

        $this->assertArrayHasKey('timeout', $guzzleClientConfig);
        $this->assertEquals(300, $guzzleClientConfig['timeout']);

        $this->assertArrayHasKey('allow_redirects', $guzzleClientConfig);
        $this->assertSame(false, $guzzleClientConfig['allow_redirects']);

        $this->assertArrayHasKey('verify', $guzzleClientConfig);
        $this->assertSame(true, $guzzleClientConfig['verify']);

        $this->assertArrayHasKey('debug', $guzzleClientConfig);
        $this->assertSame(false, $guzzleClientConfig['debug']);

        $this->assertArrayHasKey('base_uri', $guzzleClientConfig);
        $baseUri = $guzzleClientConfig['base_uri'];

        $this->assertInstanceOf(Uri::class, $baseUri);
        $this->assertEquals('https', $baseUri->getScheme());
        $this->assertEquals('example.com', $baseUri->getHost());
    }

    public function testClientConfiguration(): void
    {
        $loggerMock = $this->createMock(LoggerInterface::class);
        $this->factory
            ->setAutoLogin(false)
            ->setLogger($loggerMock);

        $clientMock = $this->createMock(ClientInterface::class);
        $this->factory->setClient($clientMock);

        $mng = $this->factory->make();
        $this->assertInstanceOf(Mng::class, $mng);

        $mngClient = $this->getPrivateProperty($mng, 'client');
        $this->assertInstanceOf(MngClient::class, $mngClient);

        $httpClient = $this->getPrivateProperty($mngClient, 'client');
        $this->assertSame($httpClient, $clientMock);
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->factory = new Factory(
            'API_KEY',
            'API_SECRET',
            'USERNAME',
            'PASS',
            'CLIENT_NUMBER'
        );
    }
}

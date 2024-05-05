<?php

declare(strict_types=1);

use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Uri;
use H22k\MngKargo\Contract\ClientInterface;
use H22k\MngKargo\Factory;
use H22k\MngKargo\Mng;
use H22k\MngKargo\MngClient;
use H22k\MngKargo\Test\MngTestCase;
use Psr\Log\LoggerInterface;

uses(MngTestCase::class);
test('has methods', function () {
    expect(method_exists($this->factory, 'setLogger'))->toBeTrue()
        ->and(method_exists($this->factory, 'setHttpTimeout'))->toBeTrue()
        ->and(method_exists($this->factory, 'setCookies'))->toBeTrue()
        ->and(method_exists($this->factory, 'setDebug'))->toBeTrue()
        ->and(method_exists($this->factory, 'setSslVerify'))->toBeTrue()
        ->and(method_exists($this->factory, 'setAutoLogin'))->toBeTrue()
        ->and(method_exists($this->factory, 'setBaseUrl'))->toBeTrue()
        ->and(method_exists($this->factory, 'setClient'))->toBeTrue()
        ->and(method_exists($this->factory, 'setAllowRedirects'))->toBeTrue()
        ->and(method_exists($this->factory, 'setHttpTimeout'))->toBeTrue()
        ->and(method_exists($this->factory, 'setThrowHttpExceptions'))->toBeTrue()
        ->and(method_exists($this->factory, 'setHeaders'))->toBeTrue();
});
test('create returns factory instance', function () {
    $factory = Factory::create(
        'API_KEY',
        'API_SECRET',
        'USER',
        'PASS',
        'CLIENT',
    );

    expect($factory)->toBeInstanceOf(Factory::class)
        ->and($this->getPrivateProperty($factory, 'apiKey'))->toBe('API_KEY')
        ->and($this->getPrivateProperty($factory, 'apiSecret'))->toBe('API_SECRET')
        ->and($this->getPrivateProperty($factory, 'username'))->toBe('USER')
        ->and($this->getPrivateProperty($factory, 'password'))->toBe('PASS')
        ->and($this->getPrivateProperty($factory, 'mngClientNumber'))->toBe('CLIENT');
});
test('make returns mng instance', function () {
    expect($this->factory->make())->toBeInstanceOf(Mng::class);
});
test('guzzle client configuration', function () {
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
    expect($mng)->toBeInstanceOf(Mng::class);

    $mngClient = $this->getPrivateProperty($mng, 'client');
    expect($mngClient)->toBeInstanceOf(MngClient::class);

    $guzzleClient = $this->getPrivateProperty($mngClient, 'client');
    expect($guzzleClient)->toBeInstanceOf(Client::class);

    $guzzleClientConfig = $this->getPrivateProperty($guzzleClient, 'config');
    expect($guzzleClientConfig)->toBeArray()
        ->and($guzzleClientConfig)->toHaveKey('headers')
        ->and($guzzleClientConfig['headers'])->toHaveKey('User-Agent')
        ->and($guzzleClientConfig['headers']['User-Agent'])->toBe('GuzzleHttp/7')
        ->and($guzzleClientConfig)->toHaveKey('timeout')
        ->and($guzzleClientConfig['timeout'])->toBe(300)
        ->and($guzzleClientConfig)->toHaveKey('allow_redirects')
        ->and($guzzleClientConfig['allow_redirects'])->toBe(false)
        ->and($guzzleClientConfig)->toHaveKey('timeout')
        ->and($guzzleClientConfig['timeout'])->toBe(300)
        ->and($guzzleClientConfig)->toHaveKey('verify')
        ->and($guzzleClientConfig['verify'])->toBe(true)
        ->and($guzzleClientConfig)->toHaveKey('debug')
        ->and($guzzleClientConfig['debug'])->toBe(false)
        ->and($guzzleClientConfig)->toHaveKey('base_uri')
        ->and($baseUri = $guzzleClientConfig['base_uri'])->toBeInstanceOf(Uri::class);

    expect($baseUri->getScheme())->toBe('https');
    expect($baseUri->getHost())->toBe('example.com');
});
test('client configuration', function () {
    $loggerMock = $this->createMock(LoggerInterface::class);
    $this->factory
        ->setAutoLogin(false)
        ->setLogger($loggerMock);

    $clientMock = $this->createMock(ClientInterface::class);
    $this->factory->setClient($clientMock);

    $mng = $this->factory->make();
    expect($mng)->toBeInstanceOf(Mng::class);

    $mngClient = $this->getPrivateProperty($mng, 'client');
    expect($mngClient)->toBeInstanceOf(MngClient::class);

    $httpClient = $this->getPrivateProperty($mngClient, 'client');
    expect($httpClient)->toBe($clientMock);
});
beforeEach(function () {
    $this->factory = new Factory(
        'API_KEY',
        'API_SECRET',
        'USERNAME',
        'PASS',
        'CLIENT_NUMBER'
    );
});

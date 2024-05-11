<?php

declare(strict_types=1);

namespace H22k\MngKargo\Test\Unit;

use H22k\MngKargo\Contract\ClientInterface;
use H22k\MngKargo\Mng;
use H22k\MngKargo\MngClient;
use H22k\MngKargo\Resource\BarcodeCommand;
use H22k\MngKargo\Resource\CbsInfo;
use H22k\MngKargo\Service\LoginService;
use H22k\MngKargo\Test\MngTestCase;
use PHPUnit\Framework\Attributes\CoversClass;

#[CoversClass(Mng::class)]
class MngTest extends MngTestCase
{
    private Mng $mng;

    public function testCbsInfo(): void
    {
        $this->assertInstanceOf(CbsInfo::class, $this->mng->cbsInfo());
    }

    public function testBarcodeCommand(): void
    {
        $this->assertInstanceOf(BarcodeCommand::class, $this->mng->barcodeCommand());
    }

    protected function setUp(): void
    {
        parent::setUp();

        $clientMock = $this->createMock(ClientInterface::class);
        $loginServiceMock = $this->createMock(LoginService::class);

        $mngClientMock = new MngClient($clientMock, $loginServiceMock, 'API_KEY', 'API_SECRET');
        $this->mng = new Mng($mngClientMock);
    }
}

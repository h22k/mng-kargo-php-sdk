<?php

declare(strict_types=1);

namespace H22k\MngKargo\Test\Unit\Resource;

use GuzzleHttp\Exception\GuzzleException;
use H22k\MngKargo\Resource\CbsInfo;
use H22k\MngKargo\Test\MngTestCase;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\MockObject\Exception;

#[CoversClass(CbsInfo::class)]
class CbsInfoTest extends MngTestCase
{
    /**
     * @throws GuzzleException
     * @throws Exception
     */
    public function testGetCities(): void
    {
        $mngClientMock = $this->getMockMngClient([
            $this->getResponseMock(200, [['code' => '34', 'name' => 'İstanbul']]),
        ]);

        $cbsInfo = new CbsInfo($mngClientMock);

        $cities = $cbsInfo->getCities()->cities();

        $this->assertIsArray($cities);
        $this->assertCount(1, $cities);
        $this->assertSame('34', $cities[0]->getCode());
        $this->assertSame('İstanbul', $cities[0]->getName());
    }
}

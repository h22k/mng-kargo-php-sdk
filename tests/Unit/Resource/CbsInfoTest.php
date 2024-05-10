<?php

declare(strict_types=1);

namespace H22k\MngKargo\Test\Unit\Resource;

use GuzzleHttp\Exception\GuzzleException;
use H22k\MngKargo\Exception\InvalidObjectException;
use H22k\MngKargo\Model\Response\Object\City;
use H22k\MngKargo\Model\Response\Object\District;
use H22k\MngKargo\Resource\CbsInfo;
use H22k\MngKargo\Test\MngTestCase;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\MockObject\Exception;

#[CoversClass(CbsInfo::class)]
class CbsInfoTest extends MngTestCase
{
    /**
     * @throws GuzzleException
     * @throws Exception|InvalidObjectException
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

    public function testGetDistricts(): void
    {
        $mngClientMock = $this->getMockMngClient([
            $this->getResponseMock(
                200,
                [['code' => '85', 'name' => 'Çukurova', 'cityCode' => "01", 'cityName' => 'Adana']]
            ),
        ]);

        $cityMock = $this->createMock(City::class);
        $cityMock->expects($this->once())
            ->method('getCode')
            ->willReturn("01");

        $cbsInfo = new CbsInfo($mngClientMock);
        $districts = $cbsInfo->getDistricts($cityMock)->districts();

        $this->assertCount(1, $districts);
        $this->assertInstanceOf(District::class, $districts[0]);
        $this->assertSame('85', $districts[0]->getCode());
        $this->assertSame('Çukurova', $districts[0]->getName());

        $this->assertSame($cityMock, $districts[0]->getCity());
    }
}

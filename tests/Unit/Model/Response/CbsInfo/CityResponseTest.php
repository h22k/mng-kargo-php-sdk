<?php

declare(strict_types=1);

namespace H22k\MngKargo\Test\Unit\Model\Response\CbsInfo;

use Generator;
use H22k\MngKargo\Model\Object\City;
use H22k\MngKargo\Model\Response\CbsInfo\CityResponse;
use H22k\MngKargo\Test\Unit\Model\Response\MngResponseTestCase;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;

#[CoversClass(CityResponse::class)]
class CityResponseTest extends MngResponseTestCase
{
    public static function fromDataProvider(): Generator
    {
        yield 'empty array' => [
            [],
            'expectedCityCount' => 0
        ];

        yield 'array with one single element' => [
            [['code' => '34', 'name' => 'İstanbul']],
            'expectedCityCount' => 1
        ];

        yield 'array with two elements' => [
            [['code' => '34', 'name' => 'İstanbul'], ['code' => '09', 'name' => 'Aydın']],
            'expectedCityCount' => 2
        ];
    }

    #[DataProvider('fromDataProvider')]
    public function testFrom(array $responseBody, int $expectedCityCount): void
    {
        $responseTransformerServiceMock = $this->getResponseTransformerServiceMock(
            $responseBody
        );

        $cityResponse = CityResponse::from($responseTransformerServiceMock);

        $this->assertCount($expectedCityCount, $cityResponse->cities());

        foreach ($responseBody as $key => $item) {
            $city = $cityResponse->cities()[$key];

            $this->assertInstanceOf(City::class, $city);
            $this->assertSame($item['code'], $city->getCode());
            $this->assertSame($item['name'], $city->getName());
        }
    }
}

<?php

declare(strict_types=1);

namespace H22k\MngKargo\Test\Unit\Model\Response\CbsInfo;

use Generator;
use H22k\MngKargo\Model\Response\CbsInfo\DistrictResponse;
use H22k\MngKargo\Model\Response\Object\City;
use H22k\MngKargo\Test\Unit\Model\Response\MngResponseTestCase;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;

#[CoversClass(DistrictResponse::class)]
class DistrictResponseTest extends MngResponseTestCase
{
    public static function fromDataProvider(): Generator
    {
        yield 'empty array' => [
            [],
            'city' => new City('01', 'Adana'),
            'expectedDistrictCount' => 0
        ];

        yield 'array with one single element' => [
            [['code' => '85', 'name' => 'Ilce', 'cityCode' => '01', 'cityName' => 'Adana']],
            'city' => new City('01', 'Adana'),
            'expectedDistrictCount' => 1,
        ];

        yield 'array with two elements' => [
            [
                ['code' => '90', 'name' => 'Ilce2', 'cityCode' => '01', 'cityName' => 'Adana'],
                ['code' => '91', 'name' => 'Ilce3', 'cityCode' => '01', 'cityName' => 'Adana']
            ],
            'city' => new City('01', 'Adana'),
            'expectedDistrictCount' => 2
        ];
    }

    #[DataProvider('fromDataProvider')]
    public function testFrom(array $responseBody, City $city, int $expectedDistrictCount): void
    {
        $responseTransformerServiceMock = $this->getResponseTransformerServiceMock(
            $responseBody
        );

        $districtResponse = DistrictResponse::from($responseTransformerServiceMock, $city);
        $this->assertCount($expectedDistrictCount, $districtResponse->districts());

        foreach ($responseBody as $key => $item) {
            $district = $districtResponse->districts()[$key];

            $this->assertSame($item['code'], $district->getCode());
            $this->assertSame($item['name'], $district->getName());

            $this->assertSame($city, $district->getCity());
        }
    }
}

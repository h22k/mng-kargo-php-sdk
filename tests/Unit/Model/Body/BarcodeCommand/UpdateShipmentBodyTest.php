<?php

declare(strict_types=1);

namespace H22k\MngKargo\Test\Unit\Model\Body\BarcodeCommand;

use H22k\MngKargo\Model\Body\BarcodeCommand\Trait\HasOrderPieceList;
use H22k\MngKargo\Model\Body\BarcodeCommand\UpdateShipmentBody;
use H22k\MngKargo\Test\MngTestCase;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use TypeError;

#[CoversClass(UpdateShipmentBody::class)]
class UpdateShipmentBodyTest extends MngTestCase
{
    public function testToArray(): void
    {
        $updateShipmentBody = new UpdateShipmentBody(
            'reference-id',
            'shipment-id',
            'bill-of-landing-id',
            1,
            null,
            [],
        );

        $updateShipmentBodyAsArray = $updateShipmentBody->toArray();

        // Make sure CreateBarcodeBody uses HasOrderPieceList
        $this->assertContains(HasOrderPieceList::class, class_uses($updateShipmentBody));

        $this->assertIsArray($updateShipmentBodyAsArray);
        $this->assertCount(6, $updateShipmentBodyAsArray);

        $this->assertArrayHasKey('referenceId', $updateShipmentBodyAsArray);
        $this->assertArrayHasKey('shipmentId', $updateShipmentBodyAsArray);
        $this->assertArrayHasKey('billOfLandingId', $updateShipmentBodyAsArray);
        $this->assertArrayHasKey('isCOD', $updateShipmentBodyAsArray);
        $this->assertArrayHasKey('codAmount', $updateShipmentBodyAsArray);
        $this->assertArrayHasKey('orderPieceList', $updateShipmentBodyAsArray);

        $this->assertSame('reference-id', $updateShipmentBodyAsArray['referenceId']);
        $this->assertSame('shipment-id', $updateShipmentBodyAsArray['shipmentId']);
        $this->assertSame('bill-of-landing-id', $updateShipmentBodyAsArray['billOfLandingId']);
        $this->assertSame(1, $updateShipmentBodyAsArray['isCOD']);
        $this->assertNull($updateShipmentBodyAsArray['codAmount']);
        $this->assertSame([], $updateShipmentBodyAsArray['orderPieceList']);
    }

    public static function orderPieceListDataProvider(): array
    {
        return [
            'string order piece list' => [
                'orderPieceList' => ['string'],
            ],
            'int order piece list' => [
                'orderPieceList' => [1],
            ],
            'bool order piece list' => [
                'orderPieceList' => [true],
            ],
            'array order piece list' => [
                'orderPieceList' => [[]],
            ],
            'object order piece list' => [
                'orderPieceList' => [new \stdClass()],
            ],
        ];
    }

    #[DataProvider('orderPieceListDataProvider')]
    public function testOrderPieceListsEveryElementShouldBeOrderPiece(
        array $orderPieceList,
    ): void {
        $this->expectException(TypeError::class);

        new UpdateShipmentBody(
            'reference-id',
            'shipment-id',
            'bill-of-landing-id',
            1,
            1.00,
            $orderPieceList
        );
    }
}

<?php

declare(strict_types=1);

namespace H22k\MngKargo\Test\Unit\Model\Body\BarcodeCommand;

use H22k\MngKargo\Model\Body\BarcodeCommand\CancelShipmentBody;
use H22k\MngKargo\Test\MngTestCase;
use PHPUnit\Framework\Attributes\CoversClass;

#[CoversClass(CancelShipmentBody::class)]
class CancelShipmentBodyTest extends MngTestCase
{
    public function testToArray(): void
    {
        $cancelShipmentBody = new CancelShipmentBody('reference-id', 'shipment-id');

        $cancelShipmentBodyAsArray = $cancelShipmentBody->toArray();

        $this->assertIsArray($cancelShipmentBodyAsArray);
        $this->assertCount(2, $cancelShipmentBodyAsArray);

        $this->assertArrayHasKey('referenceId', $cancelShipmentBodyAsArray);
        $this->assertArrayHasKey('shipmentId', $cancelShipmentBodyAsArray);

        $this->assertSame('reference-id', $cancelShipmentBodyAsArray['referenceId']);
        $this->assertSame('shipment-id', $cancelShipmentBodyAsArray['shipmentId']);
    }
}

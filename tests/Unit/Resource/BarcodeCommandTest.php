<?php

declare(strict_types=1);

namespace H22k\MngKargo\Test\Unit\Resource;

use GuzzleHttp\Psr7\Response;
use H22k\MngKargo\Model\Body\BarcodeCommand\CancelShipmentBody;
use H22k\MngKargo\Model\Body\BarcodeCommand\CreateBarcodeBody;
use H22k\MngKargo\Model\Body\BarcodeCommand\UpdateShipmentBody;
use H22k\MngKargo\Model\Object\Barcode;
use H22k\MngKargo\Resource\BarcodeCommand;
use H22k\MngKargo\Test\MngTestCase;
use PHPUnit\Framework\Attributes\CoversClass;

#[CoversClass(BarcodeCommand::class)]
class BarcodeCommandTest extends MngTestCase
{
    public function testCreateBarcode(): void
    {
        $mngClientMock = $this->getMockMngClient([
            new Response(200, body: json_encode([
                'referenceId' => 'SIPARIS34567',
                'invoiceId' => '564645774',
                'shipmentId' => '4536457657',
                'barcodes' => [
                    [
                        'pieceNumber' => 1,
                        'value' => 'Barcode1'
                    ]
                ]
            ], JSON_THROW_ON_ERROR))
        ]);

        $barcodeCommand = new BarcodeCommand($mngClientMock);
        $createBarcodeBodyMock = $this->createMock(CreateBarcodeBody::class);

        $createBarcodeBodyMock->expects($this->once())
            ->method('toArray')
            ->willReturn([
                'referenceId' => 'SIPARIS34567',
                'billOfLandingId' => 'bill-of-landing-id',
                'isCOD' => 1,
                'codAmount' => 1.00,
                'packagingType' => 1,
                'printReferenceBarcodeOnError' => 1,
                'message' => 'foo',
                'additionalContent1' => 'additional content',
                'additionalContent2' => 'additional content',
                'additionalContent3' => 'additional content',
                'additionalContent4' => 'additional content',
                'orderPieceList' => [],
            ]);

        $createBarcodeResponse = $barcodeCommand->createBarcode($createBarcodeBodyMock);

        $this->assertSame('SIPARIS34567', $createBarcodeResponse->getReferenceId());
        $this->assertSame('564645774', $createBarcodeResponse->getInvoiceId());
        $this->assertSame('4536457657', $createBarcodeResponse->getShipmentId());

        $this->assertCount(1, $createBarcodeResponse->getBarcodes());
        $this->assertInstanceOf(Barcode::class, $createBarcodeResponse->getBarcodes()[0]);
        $this->assertSame(1, $createBarcodeResponse->getBarcodes()[0]->getPieceNumber());
        $this->assertSame('Barcode1', $createBarcodeResponse->getBarcodes()[0]->getValue());
    }

    public function testUpdateShipment(): void
    {
        $responseMock = new Response(200);
        $mngClientMock = $this->getMockMngClient([
            $responseMock
        ]);

        $barcodeCommand = new BarcodeCommand($mngClientMock);
        $updateShipmentBodyMock = $this->createMock(UpdateShipmentBody::class);

        $updateShipmentBodyMock->expects($this->once())
            ->method('toArray')
            ->willReturn([
                'referenceId' => 'SIPARIS34567',
                'shipmentId' => '4536457657',
                'billOfLandingId' => 'bill-of-landing-id',
                'isCOD' => 1,
                'codAmount' => 1.00,
                'orderPieceList' => [],
            ]);

        $updateShipmentResponse = $barcodeCommand->updateShipment($updateShipmentBodyMock);
        $this->assertSame($responseMock, $updateShipmentResponse->getOriginalResponse());
    }

    public function testCancelShipment(): void
    {
        $responseMock = new Response(200);
        $mngClientMock = $this->getMockMngClient([
            $responseMock
        ]);

        $barcodeCommand = new BarcodeCommand($mngClientMock);
        $cancelShipmentBodyMock = $this->createMock(CancelShipmentBody::class);

        $cancelShipmentBodyMock->expects($this->once())
            ->method('toArray')
            ->willReturn([
                'referenceId' => 'SIPARIS34567',
                'shipmentId' => '4536457657'
            ]);

        $updateShipmentResponse = $barcodeCommand->cancelShipment($cancelShipmentBodyMock);
        $this->assertSame($responseMock, $updateShipmentResponse->getOriginalResponse());
    }
}

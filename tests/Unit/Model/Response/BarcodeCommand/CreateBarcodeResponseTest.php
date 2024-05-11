<?php

declare(strict_types=1);

namespace H22k\MngKargo\Test\Unit\Model\Response\BarcodeCommand;

use Generator;
use H22k\MngKargo\Model\Object\Barcode;
use H22k\MngKargo\Model\Response\BarcodeCommand\CreateBarcodeResponse;
use H22k\MngKargo\Test\Unit\Model\Response\MngResponseTestCase;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;

#[CoversClass(CreateBarcodeResponse::class)]
class CreateBarcodeResponseTest extends MngResponseTestCase
{
    public static function fromDataProvider(): Generator
    {
        yield 'all values provided' => [
            [
                'referenceId' => 'reference-id',
                'invoiceId' => 'invoice-id',
                'shipmentId' => 'shipment-id',
                'barcodes' => [
                    [
                        'pieceNumber' => 1,
                        'value' => 'value'
                    ],
                ]
            ]
        ];

        yield 'one value not provided' => [
            [
                'referenceId' => 'reference-id',
                'invoiceId' => 'invoice-id',
                'shipmentId' => 'shipment-id',
                'barcodes' => [],
            ]
        ];
    }

    #[DataProvider('fromDataProvider')]
    public function testFrom(array $responseBody): void
    {
        $responseTransformerServiceMock = $this->getResponseTransformerServiceMock(
            $responseBody
        );

        $createBarcodeResponse = CreateBarcodeResponse::from($responseTransformerServiceMock);

        $this->assertSame($responseBody['referenceId'], $createBarcodeResponse->getReferenceId());
        $this->assertSame($responseBody['invoiceId'], $createBarcodeResponse->getInvoiceId());
        $this->assertSame($responseBody['shipmentId'], $createBarcodeResponse->getShipmentId());

        foreach ($responseBody['barcodes'] as $key => $barcodeAsArray) {
            $barcode = $createBarcodeResponse->getBarcodes()[$key];

            $this->assertInstanceOf(Barcode::class, $barcode);
            $this->assertSame($barcodeAsArray['pieceNumber'], $barcode->getPieceNumber());
            $this->assertSame($barcodeAsArray['value'], $barcode->getValue());
        }
    }
}

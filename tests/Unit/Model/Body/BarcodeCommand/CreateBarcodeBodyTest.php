<?php

declare(strict_types=1);

namespace H22k\MngKargo\Test\Unit\Model\Body\BarcodeCommand;

use H22k\MngKargo\Model\Body\BarcodeCommand\CreateBarcodeBody;
use H22k\MngKargo\Model\Body\BarcodeCommand\Trait\HasOrderPieceList;
use H22k\MngKargo\Test\MngTestCase;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use TypeError;

#[CoversClass(CreateBarcodeBody::class)]
class CreateBarcodeBodyTest extends MngTestCase
{
    public function testToArray(): void
    {
        $createBarcodeBody = new CreateBarcodeBody(
            'reference-id',
            'bill-of-landing-id',
            1,
            1.00,
            1,
            null,
            'message',
            'addition',
            'addition-2',
            null,
            null,
            []
        );

        // Make sure CreateBarcodeBody uses HasOrderPieceList
        $this->assertContains(HasOrderPieceList::class, class_uses($createBarcodeBody));

        $createBarcodeBodyAsArray = $createBarcodeBody->toArray();

        $this->assertIsArray($createBarcodeBodyAsArray);
        $this->assertCount(12, $createBarcodeBodyAsArray);

        $this->assertArrayHasKey('referenceId', $createBarcodeBodyAsArray);
        $this->assertArrayHasKey('billOfLandingId', $createBarcodeBodyAsArray);
        $this->assertArrayHasKey('isCOD', $createBarcodeBodyAsArray);
        $this->assertArrayHasKey('codAmount', $createBarcodeBodyAsArray);
        $this->assertArrayHasKey('packagingType', $createBarcodeBodyAsArray);
        $this->assertArrayHasKey('printReferenceBarcodeOnError', $createBarcodeBodyAsArray);
        $this->assertArrayHasKey('message', $createBarcodeBodyAsArray);
        $this->assertArrayHasKey('additionalContent1', $createBarcodeBodyAsArray);
        $this->assertArrayHasKey('additionalContent2', $createBarcodeBodyAsArray);
        $this->assertArrayHasKey('additionalContent3', $createBarcodeBodyAsArray);
        $this->assertArrayHasKey('additionalContent4', $createBarcodeBodyAsArray);
        $this->assertArrayHasKey('orderPieceList', $createBarcodeBodyAsArray);

        $this->assertSame('reference-id', $createBarcodeBodyAsArray['referenceId']);
        $this->assertSame('bill-of-landing-id', $createBarcodeBodyAsArray['billOfLandingId']);
        $this->assertSame(1, $createBarcodeBodyAsArray['isCOD']);
        $this->assertSame(1.00, $createBarcodeBodyAsArray['codAmount']);
        $this->assertSame(1, $createBarcodeBodyAsArray['packagingType']);
        $this->assertNull($createBarcodeBodyAsArray['printReferenceBarcodeOnError']);
        $this->assertSame('message', $createBarcodeBodyAsArray['message']);
        $this->assertSame('addition', $createBarcodeBodyAsArray['additionalContent1']);
        $this->assertSame('addition-2', $createBarcodeBodyAsArray['additionalContent2']);
        $this->assertNull($createBarcodeBodyAsArray['additionalContent3']);
        $this->assertNull($createBarcodeBodyAsArray['additionalContent4']);
    }

    #[DataProvider('orderPieceListDataProvider')]
    public function testOrderPieceListsEveryElementShouldBeOrderPiece(
        array $orderPieceList,
    ): void {
        $this->expectException(TypeError::class);

        new CreateBarcodeBody(
            'reference-id',
            'bill-of-landing-id',
            1,
            1.00,
            1,
            null,
            'message',
            'addition',
            'addition-2',
            null,
            null,
            $orderPieceList
        );
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
}

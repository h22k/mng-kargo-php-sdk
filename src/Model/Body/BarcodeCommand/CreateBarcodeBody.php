<?php

declare(strict_types=1);

namespace H22k\MngKargo\Model\Body\BarcodeCommand;

use H22k\MngKargo\Model\Body\BarcodeCommand\Trait\HasOrderPieceList;
use H22k\MngKargo\Model\Contract\Arrayable;
use H22k\MngKargo\Model\Object\OrderPiece;

/**
 * @implements Arrayable<array{referenceId: string, billOfLandingId: ?string, isCOD: ?int, codAmount: ?float, packagingType: ?int, printReferenceBarcodeOnError: ?int, message: ?string, additionalContent2: ?string, additionalContent3: ?string, additionalContent4: ?string, orderPieceList: array<array{barcode: string, desi: int, kg: int, content: ?string}>}>
 */
class CreateBarcodeBody implements Arrayable
{
    use HasOrderPieceList;

    /**
     * @param array<OrderPiece> $orderPieceList
     */
    public function __construct(
        private readonly string $referenceId,
        private readonly ?string $billOfLandingId = null,
        private readonly ?int $isCOD = null,
        private readonly ?float $codAmount = null,
        private readonly ?int $packagingType = null,
        private readonly ?int $printReferenceBarcodeOnError = null,
        private readonly ?string $message = null,
        private readonly ?string $additionalContent1 = null,
        private readonly ?string $additionalContent2 = null,
        private readonly ?string $additionalContent3 = null,
        private readonly ?string $additionalContent4 = null,
        array $orderPieceList = [],
    ) {
        // Use this method to be sure of every element of order piece list is instance of H22k\MngKargo\Model\Object\OrderPiece
        $this->setOrderPieceList($orderPieceList);
    }

    /**
     * @return array{referenceId: string, billOfLandingId: ?string, isCOD: ?int, codAmount: ?float, packagingType: ?int, printReferenceBarcodeOnError: ?int, message: ?string, additionalContent2: ?string, additionalContent3: ?string, additionalContent4: ?string, orderPieceList: array<array{barcode: string, desi: int, kg: int, content: ?string}>}
     */
    public function toArray(): array
    {
        return [
            'referenceId' => $this->referenceId,
            'billOfLandingId' => $this->billOfLandingId,
            'isCOD' => $this->isCOD,
            'codAmount' => $this->codAmount,
            'packagingType' => $this->packagingType,
            'printReferenceBarcodeOnError' => $this->printReferenceBarcodeOnError,
            'message' => $this->message,
            'additionalContent1' => $this->additionalContent1,
            'additionalContent2' => $this->additionalContent2,
            'additionalContent3' => $this->additionalContent3,
            'additionalContent4' => $this->additionalContent4,
            'orderPieceList' => $this->getOrderPieceListAsArray(),
        ];
    }
}

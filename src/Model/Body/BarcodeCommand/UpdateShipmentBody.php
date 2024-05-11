<?php

declare(strict_types=1);

namespace H22k\MngKargo\Model\Body\BarcodeCommand;

use H22k\MngKargo\Model\Body\BarcodeCommand\Trait\HasOrderPieceList;
use H22k\MngKargo\Model\Contract\Arrayable;
use H22k\MngKargo\Model\Object\OrderPiece;

/**
 * @implements Arrayable<array{referenceId: string, shipmentId: string, billOfLandingId: ?string, isCOD: ?int, codAmount: ?float, orderPieceList: array<array{barcode: string, desi: int, kg: int, content: ?string}>}>
 */
class UpdateShipmentBody implements Arrayable
{
    use HasOrderPieceList;

    /**
     * @param array<OrderPiece> $orderPieceList
     */
    public function __construct(
        private readonly string $referenceId,
        private readonly string $shipmentId,
        private readonly ?string $billOfLandingId = null,
        private readonly ?int $isCOD = null,
        private readonly ?float $codAmount = null,
        array $orderPieceList = []
    ) {
        // Use this method to be sure of every element of order piece list is instance of H22k\MngKargo\Model\Object\OrderPiece
        $this->setOrderPieceList($orderPieceList);
    }

    /**
     * @return array{referenceId: string, shipmentId: string, billOfLandingId: ?string, isCOD: ?int, codAmount: ?float, orderPieceList: array<array{barcode: string, desi: int, kg: int, content: ?string}>}
     */
    public function toArray(): array
    {
        return [
            'referenceId' => $this->referenceId,
            'shipmentId' => $this->shipmentId,
            'billOfLandingId' => $this->billOfLandingId,
            'isCOD' => $this->isCOD,
            'codAmount' => $this->codAmount,
            'orderPieceList' => $this->getOrderPieceListAsArray(),
        ];
    }
}

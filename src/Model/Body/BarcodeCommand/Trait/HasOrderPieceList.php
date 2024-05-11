<?php

declare(strict_types=1);

namespace H22k\MngKargo\Model\Body\BarcodeCommand\Trait;

use H22k\MngKargo\Model\Object\OrderPiece;

trait HasOrderPieceList
{
    /**
     * @var array<OrderPiece>
     */
    private array $orderPieceList = [];

    /**
     * @param array<OrderPiece> $orderPieceList
     * @return void
     */
    private function setOrderPieceList(array $orderPieceList): void
    {
        foreach ($orderPieceList as $orderPiece) {
            // Making sure of every element is instance of H22k\MngKargo\Model\Object\OrderPiece
            $this->addOrderPiece($orderPiece);
        }
    }

    public function addOrderPiece(OrderPiece $orderPiece): self
    {
        $this->orderPieceList[] = $orderPiece;

        return $this;
    }

    /**
     * @return array<array{barcode: string, desi: int, kg: int, content: ?string}>
     */
    private function getOrderPieceListAsArray(): array
    {
        $orderPieceList = [];

        foreach ($this->orderPieceList as $orderPiece) {
            $orderPieceList[] = $orderPiece->toArray();
        }

        return $orderPieceList;
    }
}

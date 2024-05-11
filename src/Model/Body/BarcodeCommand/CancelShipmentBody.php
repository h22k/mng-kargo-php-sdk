<?php

declare(strict_types=1);

namespace H22k\MngKargo\Model\Body\BarcodeCommand;

use H22k\MngKargo\Model\Contract\Arrayable;

/**
 * @implements Arrayable<array{referenceId: string, shipmentId: string}>
 */
class CancelShipmentBody implements Arrayable
{
    public function __construct(
        private readonly string $referenceId,
        private readonly string $shipmentId,
    ) {
    }

    /**
     * @return array{referenceId: string, shipmentId: string}
     */
    public function toArray(): array
    {
        return [
            'referenceId' => $this->referenceId,
            'shipmentId' => $this->shipmentId,
        ];
    }
}

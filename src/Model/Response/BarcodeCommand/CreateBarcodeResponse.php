<?php

declare(strict_types=1);

namespace H22k\MngKargo\Model\Response\BarcodeCommand;

use H22k\MngKargo\Exception\InvalidJsonException;
use H22k\MngKargo\Model\Object\Barcode;
use H22k\MngKargo\Model\Response\MngResponse;
use H22k\MngKargo\Service\ResponseTransformerService;
use Psr\Http\Message\ResponseInterface;

class CreateBarcodeResponse extends MngResponse
{
    /**
     * @param ResponseInterface $response
     * @param string $referenceId
     * @param string $invoiceId
     * @param string $shipmentId
     * @param array<Barcode> $barcodes
     */
    public function __construct(
        ResponseInterface $response,
        private readonly string $referenceId,
        private readonly string $invoiceId,
        private readonly string $shipmentId,
        private readonly array $barcodes,
    ) {
        parent::__construct($response);
    }

    /**
     * @param ResponseTransformerService<array{referenceId: string, invoiceId: string, shipmentId: string, barcodes: array<array{pieceNumber: int, value: string}>}> $transformerService
     * @return self
     * @throws InvalidJsonException
     */
    public static function from(ResponseTransformerService $transformerService): self
    {
        $body     = $transformerService->getBody();
        $barcodes = [];

        foreach ($body['barcodes'] as $barcode) {
            $barcodes[] = new Barcode($barcode['pieceNumber'], $barcode['value']);
        }

        return new self(
            $transformerService->getResponse(),
            $body['referenceId'],
            $body['invoiceId'],
            $body['shipmentId'],
            $barcodes
        );
    }

    public function getReferenceId(): string
    {
        return $this->referenceId;
    }

    public function getInvoiceId(): string
    {
        return $this->invoiceId;
    }

    public function getShipmentId(): string
    {
        return $this->shipmentId;
    }

    /**
     * @return array<Barcode>
     */
    public function getBarcodes(): array
    {
        return $this->barcodes;
    }
}

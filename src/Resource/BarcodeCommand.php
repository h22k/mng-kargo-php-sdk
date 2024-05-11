<?php

declare(strict_types=1);

namespace H22k\MngKargo\Resource;

use GuzzleHttp\Exception\GuzzleException;
use H22k\MngKargo\Exception\InvalidJsonException;
use H22k\MngKargo\Http\Payload;
use H22k\MngKargo\Http\ValueObject\Body;
use H22k\MngKargo\Model\Body\BarcodeCommand\CancelShipmentBody;
use H22k\MngKargo\Model\Body\BarcodeCommand\CreateBarcodeBody;
use H22k\MngKargo\Model\Body\BarcodeCommand\UpdateShipmentBody;
use H22k\MngKargo\Model\Response\BarcodeCommand\CreateBarcodeResponse;
use H22k\MngKargo\Model\Response\EmptyResponse;
use H22k\MngKargo\Service\ResponseTransformerService;

/**
 * [TR] Siparişi faturalaştırarak gönderiye çeviren, gönderiyi güncelleyen ve iptal eden metodların yer aldığı API'dır.
 * [EN] It is the API that converts the order to the shipment by invoicing, updating and cancelling the shipment.
 * @see https://apizone.mngkargo.com.tr/index.php/tr/product/3873/api/1739#/BarcodeCommandAPI_10/overview
 */
class BarcodeCommand extends AbstractResource
{
    /**
     * Resource path prefix.
     */
    public const PATH_PREFIX = 'barcodecmdapi';

    public const CREATE_BARCODE_URI = 'createbarcode';

    public const UPDATE_SHIPMENT_URI = 'updateshipment';

    public const CANCEL_SHIPMENT_URI = 'cancelshipment';

    /**
     * [TR] Siparişi faturalaştırarak gönderiye çevirir ve sonucunda bir barkod etiketi üretir.
     * [EN] Invoicing the order to the shipment and producing a barcode label as a result.
     *
     * @throws GuzzleException|InvalidJsonException
     *
     * @see https://apizone.mngkargo.com.tr/index.php/tr/product/3873/api/1739#/BarcodeCommandAPI_10/operation/%2Fcreatebarcode/post
     */
    public function createBarcode(CreateBarcodeBody $barcodeBody): CreateBarcodeResponse
    {
        $payload = new Payload(self::PATH_PREFIX . '/' . self::CREATE_BARCODE_URI, new Body($barcodeBody));

        /**
         * @var ResponseTransformerService<array{referenceId: string, invoiceId: string, shipmentId: string, barcodes: array<array{pieceNumber: int, value:string}>}> $responseTransformer
         */
        $responseTransformer = $this->client->post($payload);

        return CreateBarcodeResponse::from($responseTransformer);
    }

    /**
     * [TR] İlgili referans ve gönderi numarasına ait gönderiyi günceller.
     * [EN] Updates the shipment of the relevant reference and shipment number.
     *
     * @throws GuzzleException
     *
     * @see https://apizone.mngkargo.com.tr/index.php/tr/product/3873/api/1739#/BarcodeCommandAPI_10/operation/%2Fupdateshipment/put
     */
    public function updateShipment(UpdateShipmentBody $updateShipmentBody): EmptyResponse
    {
        $payload = new Payload(self::PATH_PREFIX . '/' . self::UPDATE_SHIPMENT_URI, new Body($updateShipmentBody));

        /**
         * @var ResponseTransformerService<array<empty>> $responseTransformer
         */
        $responseTransformer = $this->client->put($payload);

        return EmptyResponse::from($responseTransformer);
    }

    /**
     * [TR] İlgili referans ve gönderi numarasına ait gönderiyi iptal eder.
     * [EN] Cancels the shipment of the relevant reference and shipment number.
     *
     * @throws GuzzleException
     *
     * @see https://apizone.mngkargo.com.tr/index.php/tr/product/3873/api/1739#/BarcodeCommandAPI_10/operation/%2Fcancelshipment/put
     */
    public function cancelShipment(CancelShipmentBody $cancelShipmentBody): EmptyResponse
    {
        $payload = new Payload(self::PATH_PREFIX . '/' . self::CANCEL_SHIPMENT_URI, new Body($cancelShipmentBody));

        /**
         * @var ResponseTransformerService<array<empty>> $responseTransformer
         */
        $responseTransformer = $this->client->put($payload);

        return EmptyResponse::from($responseTransformer);
    }
}

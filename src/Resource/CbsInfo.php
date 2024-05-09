<?php

declare(strict_types=1);

namespace H22k\MngKargo\Resource;

use GuzzleHttp\Exception\GuzzleException;
use H22k\MngKargo\Http\Payload;
use H22k\MngKargo\Model\Response\CbsInfo\CityResponse;
use H22k\MngKargo\Model\Response\CbsInfo\DistrictResponse;
use H22k\MngKargo\Model\Response\CbsInfo\Object\City;
use H22k\MngKargo\Service\ResponseTransformerService;

class CbsInfo extends AbstractResource
{
    public const PATH_PREFIX = 'cbsinfoapi';

    public const GET_CITIES_URI = 'getcities';

    public const GET_DISTRICTS_URI = 'getdistricts';

    /**
     * @return CityResponse
     * @throws GuzzleException
     */
    public function getCities(): CityResponse
    {
        $payload = Payload::from(self::PATH_PREFIX . '/' . self::GET_CITIES_URI);

        /**
         * @var ResponseTransformerService<array{code: string, name: string}> $responseTransformerService
         */
        $responseTransformerService = $this->client->get($payload);

        return CityResponse::from($responseTransformerService);
    }

    /**
     * @param City $city
     * @return DistrictResponse
     * @throws GuzzleException
     */
    public function getDistricts(City $city): DistrictResponse
    {
        $payload = Payload::from(self::PATH_PREFIX . '/' . self::GET_DISTRICTS_URI . '/1');

        $responseTransformerService = $this->client->get($payload);

        return DistrictResponse::from($responseTransformerService, $city);
    }
}

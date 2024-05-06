<?php

declare(strict_types=1);

namespace H22k\MngKargo\Resource;

use H22k\MngKargo\Http\Payload;
use Psr\Http\Message\ResponseInterface;

class CbsInfo extends AbstractResource
{
    public const PATH_PREFIX = 'cbsinfoapi';

    public const GET_CITIES_URI = 'getcities';

    public const GET_DISTRICTS_URI = 'getdistricts';

    public function getCities(): ResponseInterface
    {
        $payload = Payload::from(self::PATH_PREFIX . '/' . self::GET_CITIES_URI);

        return $this->client->get($payload);
    }

    public function getDistricts(string|int $cityCode): ResponseInterface
    {
        $payload = Payload::from(self::PATH_PREFIX . '/' . self::GET_DISTRICTS_URI . '/' . $cityCode);

        return $this->client->get($payload);
    }
}

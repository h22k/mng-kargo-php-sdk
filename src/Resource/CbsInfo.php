<?php

declare(strict_types=1);

namespace H22k\MngKargo\Resource;

use Psr\Http\Message\ResponseInterface;

class CbsInfo extends AbstractResource
{
    public const string PATH_PREFIX = 'cbsinfoapi';

    public const string GET_CITIES_URI = 'getcities';

    public const string GET_DISTRICTS_URI = 'getdistricts';

    public function getCities(): ResponseInterface
    {
        return $this->client->get(self::PATH_PREFIX . '/' . self::GET_CITIES_URI, []);
    }

    public function getDistinct(string|int $cityCode): ResponseInterface
    {
        return $this->client->get(self::PATH_PREFIX . '/' . self::GET_DISTRICTS_URI . '/' . $cityCode, []);
    }
}

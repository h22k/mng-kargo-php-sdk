<?php

declare(strict_types=1);

namespace H22k\MngKargo\Model\Response\CbsInfo;

use H22k\MngKargo\Model\Response\CbsInfo\Object\City;
use H22k\MngKargo\Model\Response\MngResponse;
use H22k\MngKargo\Service\ResponseTransformerService;
use Psr\Http\Message\ResponseInterface;

class CityResponse extends MngResponse
{
    /**
     * @param ResponseInterface $response
     * @param array<City> $cities
     */
    public function __construct(
        ResponseInterface $response,
        private readonly array $cities,
    ) {
        parent::__construct($response);
    }

    /**
     * @param ResponseTransformerService<array{code: string, name: string}> $transformerService
     * @return CityResponse
     */
    public static function from(ResponseTransformerService $transformerService): self
    {
        $body = $transformerService->getBody();
        $cities = [];

        foreach ($body as $city) {
            $cities[] = new City(
                $city['code'],
                $city['name'],
            );
        }

        return new self($transformerService->getResponse(), $cities);
    }

    /**
     * @return array<City>
     */
    public function cities(): array
    {
        return $this->cities;
    }
}

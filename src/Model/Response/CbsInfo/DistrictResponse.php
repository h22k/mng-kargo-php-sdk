<?php

declare(strict_types=1);

namespace H22k\MngKargo\Model\Response\CbsInfo;

use H22k\MngKargo\Model\Response\MngResponse;
use H22k\MngKargo\Model\Response\Object\City;
use H22k\MngKargo\Model\Response\Object\District;
use H22k\MngKargo\Service\ResponseTransformerService;
use Psr\Http\Message\ResponseInterface;

class DistrictResponse extends MngResponse
{
    /**
     * @param ResponseInterface $response
     * @param array<District> $districts
     */
    public function __construct(
        ResponseInterface $response,
        private readonly array $districts
    ) {
        parent::__construct($response);
    }

    /**
     * @param ResponseTransformerService<array{code: string, name: string}> $transformerService
     * @param City $city
     * @return DistrictResponse
     */
    public static function from(ResponseTransformerService $transformerService, City $city): self
    {
        $body      = $transformerService->getBody();
        $districts = [];

        foreach ($body as $district) {
            $districts[] = new District(
                $district['code'],
                $district['name'],
                $city,
            );
        }

        return new self($transformerService->getResponse(), $districts);
    }

    /**
     * @return array<District>
     */
    public function districts(): array
    {
        return $this->districts;
    }
}

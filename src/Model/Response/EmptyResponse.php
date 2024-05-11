<?php

declare(strict_types=1);

namespace H22k\MngKargo\Model\Response;

use H22k\MngKargo\Service\ResponseTransformerService;

class EmptyResponse extends MngResponse
{
    /**
     * @param ResponseTransformerService<array<empty>> $responseTransformerService
     * @return self
     */
    public static function from(ResponseTransformerService $responseTransformerService): self
    {
        return new self($responseTransformerService->getResponse());
    }
}

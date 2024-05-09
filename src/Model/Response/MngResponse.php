<?php

declare(strict_types=1);

namespace H22k\MngKargo\Model\Response;

use Psr\Http\Message\ResponseInterface;

abstract class MngResponse
{
    /**
     * @param ResponseInterface $response
     */
    public function __construct(
        private readonly ResponseInterface $response,
    ) {
    }

    public function getOriginalResponse(): ResponseInterface
    {
        return $this->response;
    }
}

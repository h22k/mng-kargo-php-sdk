<?php

declare(strict_types=1);

namespace H22k\MngKargo;

use H22k\MngKargo\Resource\CbsInfo;

/**
 * Manager class to be able to access every resource easily.
 */
class Mng
{
    public function __construct(
        private readonly MngClient $client
    ) {
    }

    public function cbsInfo(): CbsInfo
    {
        return new CbsInfo($this->client);
    }
}

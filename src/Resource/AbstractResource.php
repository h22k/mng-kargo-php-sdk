<?php

declare(strict_types=1);

namespace H22k\MngKargo\Resource;

use H22k\MngKargo\MngClient;

abstract class AbstractResource
{
    public function __construct(protected MngClient $client)
    {
    }
}

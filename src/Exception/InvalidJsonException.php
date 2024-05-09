<?php

declare(strict_types=1);

namespace H22k\MngKargo\Exception;

use Exception;

class InvalidJsonException extends Exception
{
    public function __construct(Exception $exception)
    {
        parent::__construct($exception->getMessage(), 0, $exception);
    }
}

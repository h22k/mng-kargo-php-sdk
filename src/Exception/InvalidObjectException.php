<?php

declare(strict_types=1);

namespace H22k\MngKargo\Exception;

use Exception;

class InvalidObjectException extends Exception
{
    public function __construct(string $className, string $methodName, string $causedClass)
    {
        parent::__construct(
            sprintf(
                'The object you passed [%s] has to has a method named [%s]. Caused by [%s]',
                $className,
                $methodName,
                $causedClass
            )
        );
    }
}

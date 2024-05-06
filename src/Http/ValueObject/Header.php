<?php

declare(strict_types=1);

namespace H22k\MngKargo\Http\ValueObject;

use H22k\MngKargo\Contract\HttpValue;
use H22k\MngKargo\Enum\ContentType;

final class Header extends AbstractValueObject
{
    public function contentType(ContentType $contentType): HttpValue
    {
        return $this->add('Content-Type', $contentType->value);
    }
}

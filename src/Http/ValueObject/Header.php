<?php

declare(strict_types=1);

namespace H22k\MngKargo\Http\ValueObject;

use H22k\MngKargo\Enum\ContentType;

final class Header extends AbstractValueObject
{
    public function contentType(ContentType $contentType): self
    {
        return $this->add('Content-Type', $contentType->value);
    }

    public function authorization(string $authToken): self
    {
        return $this->add('Authorization', 'Bearer ' . $authToken);
    }
}

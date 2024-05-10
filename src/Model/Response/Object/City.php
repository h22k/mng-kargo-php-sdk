<?php

declare(strict_types=1);

namespace H22k\MngKargo\Model\Response\Object;

class City
{
    public function __construct(
        private readonly string $code,
        private readonly string $name,
    ) {
    }

    public function getCode(): string
    {
        return $this->code;
    }

    public function getName(): string
    {
        return $this->name;
    }
}

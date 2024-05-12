<?php

declare(strict_types=1);

namespace H22k\MngKargo\Model\Object;

// @codeCoverageIgnoreStart
class Barcode
{
    public function __construct(
        private readonly int $pieceNumber,
        private readonly string $value,
    ) {
    }

    public function getValue(): string
    {
        return $this->value;
    }

    public function getPieceNumber(): int
    {
        return $this->pieceNumber;
    }
}
// @codeCoverageIgnoreEnd

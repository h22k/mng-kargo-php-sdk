<?php

declare(strict_types=1);

namespace H22k\MngKargo\Model\Object;

use H22k\MngKargo\Model\Contract\Arrayable;

/**
 * @implements Arrayable<array{barcode: string, desi: int, kg: int, content: ?string}>
 */
class OrderPiece implements Arrayable
{
    public function __construct(
        private readonly string $barcode,
        private readonly int $desi,
        private readonly int $kg,
        private readonly ?string $content = null,
    ) {
    }

    public function getBarcode(): string
    {
        return $this->barcode;
    }

    public function getDesi(): int
    {
        return $this->desi;
    }

    public function getKg(): int
    {
        return $this->kg;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function toArray(): array
    {
        return [
            'barcode' => $this->barcode,
            'desi' => $this->desi,
            'kg' => $this->kg,
            'content' => $this->content,
        ];
    }
}

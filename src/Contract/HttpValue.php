<?php

declare(strict_types=1);

namespace H22k\MngKargo\Contract;

interface HttpValue
{
    /**
     * @return array<string, string|int|bool>
     */
    public function toArray(): array;

    public function add(string $key, string|int|bool $value): self;

    public function has(string $key): bool;
}

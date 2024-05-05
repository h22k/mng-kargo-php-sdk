<?php

declare(strict_types=1);

namespace H22k\MngKargo\Model\Contract;

/**
 * @template T of Model
 *
 * @phpstan-template T of Model
 */
interface Model
{
    /**
     * @phpstan-return T
     */
    public static function from(string $converter): self;
}

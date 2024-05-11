<?php

declare(strict_types=1);

namespace H22k\MngKargo\Model\Contract;

/**
 * @template-covariant T of array
 */
interface Arrayable
{
    /**
     * @return array
     * @phpstan-return T
     */
    public function toArray(): array;
}

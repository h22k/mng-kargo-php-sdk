<?php

declare(strict_types=1);

namespace H22k\MngKargo;

use H22k\MngKargo\Model\Contract\Model;

/**
 * @template T of Model
 */
class Converter
{
    public function __construct()
    {
    }

    /**
     * @param Model<T> $model
     *
     * @return Model<T>
     *
     * @phpstan-return T
     */
    public function as(Model $model): Model
    {
        return $model::from('selam');
    }
}

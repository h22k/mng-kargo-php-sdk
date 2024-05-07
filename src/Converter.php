<?php

declare(strict_types=1);

namespace H22k\MngKargo;

use H22k\MngKargo\Model\Contract\Model;

class Converter
{
    public function __construct()
    {
    }

    public function as(Model $model): Model
    {
        return $model::from('selam');
    }
}

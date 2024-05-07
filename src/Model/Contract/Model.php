<?php

declare(strict_types=1);

namespace H22k\MngKargo\Model\Contract;

interface Model
{
    public static function from(string $converter): self;
}

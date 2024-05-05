<?php

declare(strict_types=1);

namespace H22k\MngKargo\Model\Response\CbsInfo;

use H22k\MngKargo\Model\Contract\Model;

/**
 * @implements Model<City>
 */
readonly class City implements Model
{
    public function __construct(private string $converter)
    {
    }

    public static function from(string $converter): City
    {
        return new self($converter);
    }

    public function getHakan(): string
    {
        return $this->converter;
    }
}

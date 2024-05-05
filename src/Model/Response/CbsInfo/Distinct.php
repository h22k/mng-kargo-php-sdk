<?php

declare(strict_types=1);

namespace H22k\MngKargo\Model\Response\CbsInfo;

use H22k\MngKargo\Model\Contract\Model;

/**
 * @implements Model<Distinct>
 */
class Distinct implements Model
{
    public static function from(string $converter): Distinct
    {
        return new self();
    }
}

<?php

declare(strict_types=1);

namespace H22k\MngKargo\Enum;

enum ContentType: string
{
    case JSON = 'application/json'; // this is the only content type we are using for now
}

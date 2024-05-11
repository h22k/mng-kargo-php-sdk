<?php

declare(strict_types=1);

namespace H22k\MngKargo\Test\Unit\Model\Response;

use H22k\MngKargo\Model\Response\EmptyResponse;
use PHPUnit\Framework\Attributes\CoversClass;

#[CoversClass(EmptyResponse::class)]
class EmptyResponseTest extends MngResponseTestCase
{
    public function testFrom(): void
    {
        $responseTransformerServiceMock = $this->getResponseTransformerServiceMock(
            [],
            0
        );

        // Since we do not expect any response, we tested how many times getBody method is called
        // which in this case 0. So we tested that in there.
        EmptyResponse::from($responseTransformerServiceMock);
    }
}

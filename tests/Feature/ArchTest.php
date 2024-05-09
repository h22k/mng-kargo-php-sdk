<?php

declare(strict_types=1);

describe('arch', function () {
    arch('Not use debug functions')
        ->expect(['dd', 'var_dump'])
        ->not->toBeUsed()
    ;

    arch('All files must be strict typed')
        ->expect('H22k\MngKargo')
        ->toUseStrictTypes()
    ;

    arch('Contract folder must hold interfaces')
        ->expect('H22k\MngKargo\Contract')
        ->toBeInterface()
    ;
});

<?php

namespace Sal\PhpstanReadonlyEnforcing\Test\Dummy\Promoted;

use Psr\Log\NullLogger;

class Promoted_NonReadonlyClass_Indirect
{
    public function __construct(
        private array $array1,
        private array $array2,
        private array $array3,
        private array $array4,
        private int $int1,
        private int $int2,
    ) {
        $this->array1[] = 1;
        unset($this->array2[0]);
        $this->array3 = &$this->array4;
        $this->int1 += 1;
        --$this->int2;
    }
}

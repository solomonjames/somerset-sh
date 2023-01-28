<?php

namespace App\Generators;

class UniqueIdGenerator
{
    private int $maxInt;

    public function __construct(int $maxCodeLength)
    {
        $this->maxInt = 62 ** $maxCodeLength - 1;
    }

    public function make()
    {
        return random_int(1, $this->maxInt);
    }
}

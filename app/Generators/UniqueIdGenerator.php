<?php

namespace App\Generators;

class UniqueIdGenerator
{
    private int $maxInt;

    public function __construct(int $maxCodeLength)
    {
        $this->maxInt = 62 ** $maxCodeLength - 1;
    }

    public function make(): int
    {
        try {
            return random_int(1, $this->maxInt);
        } catch (\Exception) {
            // If for some reason this fails to generate a random number,
            // we can try one more time before letting the exception bubble up.
            return random_int(1, $this->maxInt);
        }
    }
}

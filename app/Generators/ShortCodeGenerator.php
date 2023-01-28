<?php

namespace App\Generators;

class ShortCodeGenerator
{
    public function make(int $number): string
    {
        return gmp_strval(gmp_init($number, 10), 62);
    }
}

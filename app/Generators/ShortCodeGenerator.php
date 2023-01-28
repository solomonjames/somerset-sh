<?php

namespace App\Generators;

class ShortCodeGenerator
{
    public function make(int $number)
    {
        return gmp_strval(gmp_init($number, 10), 62);
    }
}

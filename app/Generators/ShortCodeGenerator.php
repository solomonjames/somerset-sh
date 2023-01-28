<?php

namespace App\Generators;

class ShortCodeGenerator
{
    public function __construct(private readonly string $characterSet)
    {
    }

    public function make(int $number): string
    {
        // The base we are converting to is based on the size of our character set.
        $base = strlen($this->characterSet);
        $modulo = $number % $base;

        // We are within the length of the character set, so we can just use
        // the character at the given position, and exit early.
        if ($number - $modulo === 0) {
            return $this->characterSet[$number];
        }

        $alphaNumericString = '';

        while ($modulo > 0 || $number > 0) {
            $alphaNumericString .= $this->characterSet[$modulo];
            $number = (int) round(($number - $modulo) / $base, 0, PHP_ROUND_HALF_DOWN);
            $modulo = $number % $base;
        }

        return $alphaNumericString;
    }
}

<?php

namespace App\Actions;

use App\Generators\ShortCodeGenerator;
use App\Generators\UniqueIdGenerator;

class ShortCodeGeneratorAction
{
    public function __construct(private readonly UniqueIdGenerator $uniqueIdGenerator, private readonly ShortCodeGenerator $shortCodeGenerator)
    {
    }

    public function execute(): string
    {
        $uniqueId = $this->uniqueIdGenerator->make();

        return $this->shortCodeGenerator->make($uniqueId);
    }
}

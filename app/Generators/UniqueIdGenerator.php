<?php

namespace App\Generators;

use App\Models\UniqueId;

class UniqueIdGenerator
{
    /**
     * This is a wrapper for the mechanism we are using to generator a unique ID.
     * Seeing as this could change with scale, we are abstracting it away into this
     * class, rather than using the model directly.
     */
    public function make(): int
    {
        return UniqueId::create()->id;
    }
}

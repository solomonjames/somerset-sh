<?php

namespace App\Actions;

use App\Models\ShortUrl;

class ShortUrlCreateAction
{
    public function __construct(private readonly ShortCodeGeneratorAction $shortCodeGeneratorAction)
    {
    }

    public function execute(string $longUrl)
    {
        $shortCode = $this->shortCodeGeneratorAction->execute();

        return ShortUrl::create([
            'short_code' => $shortCode,
            'long_url' => $longUrl,
        ]);
    }
}

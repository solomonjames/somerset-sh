<?php

namespace App\Actions;

use App\Models\ShortUrl;

class ShortUrlUpdateAction
{
    public function execute(ShortUrl $shortUrl, string $longUrl): ShortUrl
    {
        // Archive the old one first, for analytics purposes

        $shortUrl->long_url = $longUrl;
        $shortUrl->total_hits = 0;
        $shortUrl->unique_hits = 0;
        $shortUrl->save();

        return $shortUrl;
    }
}

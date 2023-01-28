<?php

namespace App\Actions;

use App\Models\ArchivedShortUrl;
use App\Models\ShortUrl;

class ArchiveShortUrlAction
{
    public function execute(ShortUrl $shortUrl)
    {
        return ArchivedShortUrl::create([
            'short_code' => $shortUrl->short_code,
            'long_url' => $shortUrl->long_url,
            'total_hits' => $shortUrl->total_hits,
            'unique_hits' => $shortUrl->unique_hits,
            'original_created_at' => $shortUrl->created_at,
            'original_updated_at' => $shortUrl->updated_at,
        ]);
    }
}

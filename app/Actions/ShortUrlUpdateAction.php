<?php

namespace App\Actions;

use App\Models\ShortUrl;
use Illuminate\Support\Facades\DB;

class ShortUrlUpdateAction
{
    public function __construct(private readonly ArchiveShortUrlAction $archiveShortUrlAction)
    {
    }

    public function execute(ShortUrl $shortUrl, string $longUrl): ShortUrl
    {
        return DB::transaction(function () use ($shortUrl, $longUrl) {
            // Archive the old one first, for historical data purposes
            $this->archiveShortUrlAction->execute($shortUrl);

            $shortUrl->long_url = $longUrl;
            $shortUrl->total_hits = 0;
            $shortUrl->unique_hits = 0;
            $shortUrl->save();

            return $shortUrl;
        });
    }
}

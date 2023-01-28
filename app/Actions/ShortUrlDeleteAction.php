<?php

namespace App\Actions;

use App\Models\ShortUrl;
use Illuminate\Support\Facades\DB;

class ShortUrlDeleteAction
{
    public function __construct(private readonly ArchiveShortUrlAction $archiveShortUrlAction)
    {
    }

    public function execute(ShortUrl $shortUrl): void
    {
        DB::transaction(function () use ($shortUrl) {
            $this->archiveShortUrlAction->execute($shortUrl);

            $shortUrl->delete();
        });
    }
}

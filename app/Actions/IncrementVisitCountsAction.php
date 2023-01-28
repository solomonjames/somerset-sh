<?php

namespace App\Actions;

use App\Models\ShortUrl;

class IncrementVisitCountsAction
{
    public function execute(ShortUrl $shortUrl, bool $isUnique)
    {
        ++$shortUrl->total_hits;

        if ($isUnique) {
            ++$shortUrl->unique_hits;
        }

        $shortUrl->save();
    }
}

<?php

namespace App\Actions;

use App\Models\ShortUrl;

class ShortUrlDeleteAction
{
    public function execute(ShortUrl $shortUrl)
    {
        // Archive the old one before deleting...

        $shortUrl->deleteOrFail();
    }
}

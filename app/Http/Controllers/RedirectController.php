<?php

namespace App\Http\Controllers;

use App\Models\ShortUrl;

class RedirectController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(ShortUrl $shortUrl)
    {
        return redirect()->away($shortUrl->long_url);
    }
}

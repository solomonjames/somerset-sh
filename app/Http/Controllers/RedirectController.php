<?php

namespace App\Http\Controllers;

use App\Jobs\HandleShortUrlVisit;
use App\Models\ShortUrl;
use Illuminate\Http\Request;

class RedirectController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request, ShortUrl $shortUrl)
    {
        $isUnique = ! $request->session()->has($shortUrl->short_code);
        $request->session()->increment($shortUrl->short_code);

        HandleShortUrlVisit::dispatch($shortUrl, $isUnique);

        return redirect()->away($shortUrl->long_url);
    }
}

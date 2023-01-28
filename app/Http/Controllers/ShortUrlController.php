<?php

namespace App\Http\Controllers;

use App\Actions\ShortCodeGeneratorAction;
use App\Actions\ShortUrlCreateAction;
use App\Http\Requests\StoreShortUrlRequest;
use App\Http\Requests\UpdateShortUrlRequest;
use App\Http\Resources\ShortUrlResource;
use App\Models\ShortUrl;

class ShortUrlController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return new ShortUrlResource(ShortUrl::paginate(50));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreShortUrlRequest $request, ShortUrlCreateAction $shortUrlCreateAction)
    {
        $longUrl = $request->validated('long_url');

        // Lets just return a found entry, so the user can move on and use the short code.
        // Alternatively, we could return an error status, but that isn't as helpful.
        if ($shortUrl = ShortUrl::longUrl($longUrl)->first()) {
            return new ShortUrlResource($shortUrl);
        }

        $shortUrl = $shortUrlCreateAction->execute($longUrl);

        return new ShortUrlResource($shortUrl);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ShortUrl  $shortUrl
     * @return \Illuminate\Http\Response
     */
    public function show(ShortUrl $shortUrl)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateShortUrlRequest  $request
     * @param  \App\Models\ShortUrl  $shortUrl
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateShortUrlRequest $request, ShortUrl $shortUrl)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ShortUrl  $shortUrl
     * @return \Illuminate\Http\Response
     */
    public function destroy(ShortUrl $shortUrl)
    {
        //
    }
}

<?php

namespace App\Http\Controllers;

use App\Actions\ShortUrlCreateAction;
use App\Actions\ShortUrlDeleteAction;
use App\Actions\ShortUrlUpdateAction;
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
        return new ShortUrlResource(ShortUrl::cursorPaginate(config('api.pagination.default_size')));
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
     */
    public function show(ShortUrl $shortUrl)
    {
        return new ShortUrlResource($shortUrl);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateShortUrlRequest $request, ShortUrl $shortUrl, ShortUrlUpdateAction $shortUrlUpdateAction)
    {
        // If for some reason the exact same long_url is provided, we could simply return them
        // the existing record, or we could just use it as a way to reset the hit counts.
        // For now, I think it would make sense to just leave the record alone and return the
        // current state.
        if ($request->validated('long_url') === $shortUrl->long_url) {
            return new ShortUrlResource($shortUrl);
        }

        $shortUrl = $shortUrlUpdateAction->execute($shortUrl, $request->validated('long_url'));

        return new ShortUrlResource($shortUrl);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ShortUrl $shortUrl, ShortUrlDeleteAction $shortUrlDeleteAction)
    {
        $shortUrlDeleteAction->execute($shortUrl);

        return response('', 204);
    }
}

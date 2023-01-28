<?php

namespace App\Http\Controllers;

use App\Actions\ShortCodeGeneratorAction;
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
    public function store(StoreShortUrlRequest $request, ShortCodeGeneratorAction $shortCodeGeneratorAction)
    {
        $shortCode = $shortCodeGeneratorAction->execute();

        $shortUrl = ShortUrl::create([
            'short_code' => $shortCode,
            'long_url' => $request->validated('long_url'),
        ]);

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

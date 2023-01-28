<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreShortUrlRequest;
use App\Http\Requests\UpdateShortUrlRequest;
use App\Models\ShortUrl;

class ShortUrlController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreShortUrlRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreShortUrlRequest $request)
    {
        //
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
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ShortUrl  $shortUrl
     * @return \Illuminate\Http\Response
     */
    public function edit(ShortUrl $shortUrl)
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

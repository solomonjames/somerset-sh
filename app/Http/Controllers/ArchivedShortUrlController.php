<?php

namespace App\Http\Controllers;

use App\Http\Resources\ArchivedShortUrlResource;
use App\Models\ArchivedShortUrl;

class ArchivedShortUrlController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return new ArchivedShortUrlResource(ArchivedShortUrl::cursorPaginate(config('api.pagination.default_size')));
    }

    /**
     * Display the specified resource.
     */
    public function show(ArchivedShortUrl $archivedShortUrl)
    {
        return new ArchivedShortUrlResource($archivedShortUrl);
    }
}

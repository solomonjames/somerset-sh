<?php

use App\Http\Controllers;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Redirect Routes
|--------------------------------------------------------------------------
|
| Here is where you can register redirect routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "redirect" middleware group.
*/

Route::get('{short_url}', Controllers\RedirectController::class);

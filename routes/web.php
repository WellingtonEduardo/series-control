<?php

use App\Http\Controllers\SerieController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect('/series');
});

Route::resource('/series', SerieController::class);
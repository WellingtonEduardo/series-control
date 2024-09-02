<?php

use App\Http\Controllers\EpisodesController;
use App\Http\Controllers\SeasonsController;
use App\Http\Controllers\SeriesController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect('/series');
});

Route::resource('/series', SeriesController::class);
Route::get('/series/{series}/seasons', [SeasonsController::class, 'index']);
Route::get('/seasons/{season}/episode', [EpisodesController::class, 'index']);
Route::post('/seasons/{season}/episode', [EpisodesController::class, 'update']);
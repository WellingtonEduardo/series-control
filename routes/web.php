<?php

use App\Http\Controllers\EpisodesController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\SeasonsController;
use App\Http\Controllers\SeriesController;
use App\Http\Controllers\UsersController;
use App\Http\Middleware\Authentication;
use App\Mail\SeriesCreated;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect('/series');
});

Route::resource('/series', SeriesController::class);

Route::middleware([Authentication::class], function () {

    Route::get('/series/{series}/seasons', [SeasonsController::class, 'index']);
    Route::get('/seasons/{season}/episode', [EpisodesController::class, 'index']);
    Route::post('/seasons/{season}/episode', [EpisodesController::class, 'update']);
});




Route::get('/login', [LoginController::class, 'index'])->name('login');
Route::post('/login', [LoginController::class, 'store'])->name('signin');
Route::post('/logout', [LoginController::class, 'destroy'])->name('logout');

Route::get('/register', [UsersController::class, 'create'])->name('users.create');
Route::post('/register', [UsersController::class, 'store'])->name('users.store');

Route::get('email', function () {
    return new SeriesCreated('Wellington', '/');
});
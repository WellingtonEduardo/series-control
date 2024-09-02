<?php

use App\Http\Controllers\EpisodesController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\SeasonsController;
use App\Http\Controllers\SeriesController;
use App\Http\Controllers\UsersController;
use Illuminate\Auth\Middleware\Authenticate;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect('/series');
})->middleware(Authenticate::class);

Route::resource('/series', SeriesController::class);
Route::get('/series/{series}/seasons', [SeasonsController::class, 'index']);
Route::get('/seasons/{season}/episode', [EpisodesController::class, 'index']);
Route::post('/seasons/{season}/episode', [EpisodesController::class, 'update']);


Route::get('/login', [LoginController::class, 'index'])->name('login');
Route::post('/login', [LoginController::class, 'store'])->name('signin');
Route::get('/logout', [LoginController::class, 'destroy'])->name('logout');

Route::get('/register', [UsersController::class, 'create'])->name('users.create');
Route::post('/register', [UsersController::class, 'store'])->name('users.store');
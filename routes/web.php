<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\CityController;

Route::get('/', [SearchController::class, 'index']);
Route::get('/search', [SearchController::class, 'autocomplete']);
Route::get('/city/{id}', [CityController::class, 'show'])->name('city.show');
<?php

use App\Http\Controllers\FichaController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::resource('ficha', 'App\Http\Controllers\FichaController');
Route::post('ficha/search-client', [FichaController::class, 'searchClient'])->name('ficha.searchClient');
Route::post('ficha/get-video-price', [FichaController::class, 'getVideoPrice'])->name('ficha.getVideoPrice');
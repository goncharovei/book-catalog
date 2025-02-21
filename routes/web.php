<?php

use App\Front\Book\Http\Controllers\BookController;
use App\Front\Publisher\Http\Controllers\CabinetController;
use Illuminate\Support\Facades\Route;

Route::get('/', [BookController::class, 'index'])->name('book.list');

Route::name('publisher.auth.')->group(function (){
    Route::namespace('App\Front\Publisher\Http\Controllers')->group(function (){
        Auth::routes();
    });
});
Route::get('cabinet', [CabinetController::class, 'index'])->name('publisher.cabinet.index');



<?php

use App\Api\V1\Book\Http\Controllers\BookController;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->middleware('auth:sanctum')->group(function (){
    Route::get('books', [BookController::class, 'books']);
    Route::get('books/{book}', [BookController::class, 'book']);
    Route::post('books', [BookController::class, 'store']);
    Route::patch('books/{book}', [BookController::class, 'updateSome']);
    Route::put('books/{book}', [BookController::class, 'update']);
    Route::delete('books/{book}', [BookController::class, 'remove']);
});

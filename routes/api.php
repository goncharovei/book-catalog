<?php

use App\Api\V1\Book\Http\Controllers\BookController;
use App\Front\Publisher\Service\AbilityPublisher;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->middleware(['auth:sanctum', 'json'])->group(function (){
    Route::get('books', [BookController::class, 'books'])
        ->middleware('ability:' . AbilityPublisher::BOOK_READ->value)
        ->name('api.books.list');
    Route::get('books/{book}', [BookController::class, 'book'])
        ->middleware('ability:' . AbilityPublisher::BOOK_READ->value)
        ->name('api.books.book');
    Route::post('books', [BookController::class, 'store'])
        ->middleware('ability:' . AbilityPublisher::BOOK_ADD->value)
        ->name('api.books.store');
    Route::patch('books/{book}', [BookController::class, 'updatePartial'])
        ->middleware('ability:' . AbilityPublisher::BOOK_EDIT->value)
        ->name('api.books.update-partial');
    Route::put('books/{book}', [BookController::class, 'update'])
        ->middleware('ability:' . AbilityPublisher::BOOK_EDIT->value)
        ->name('api.books.update');
    Route::delete('books/{book}', [BookController::class, 'remove'])
        ->middleware('ability:' . AbilityPublisher::BOOK_DELETE->value)
        ->name('api.books.remove');
});

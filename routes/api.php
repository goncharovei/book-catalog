<?php

use App\Api\V1\Book\Http\Controllers\BookController;
use App\Front\Publisher\Service\AbilityPublisher;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->middleware('auth:sanctum')->group(function (){
    Route::get('books', [BookController::class, 'books'])
        ->middleware('ability:' . AbilityPublisher::BOOK_READ->value);
    Route::get('books/{book}', [BookController::class, 'book'])
        ->middleware('ability:' . AbilityPublisher::BOOK_READ->value);
    Route::post('books', [BookController::class, 'store'])
        ->middleware('ability:' . AbilityPublisher::BOOK_ADD->value);
    Route::patch('books/{book}', [BookController::class, 'updatePartial'])
        ->middleware('ability:' . AbilityPublisher::BOOK_EDIT->value);
    Route::put('books/{book}', [BookController::class, 'update'])
        ->middleware('ability:' . AbilityPublisher::BOOK_EDIT->value);
    Route::delete('books/{book}', [BookController::class, 'remove'])
        ->middleware('ability:' . AbilityPublisher::BOOK_DELETE->value);
});

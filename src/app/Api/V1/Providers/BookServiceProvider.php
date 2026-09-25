<?php

namespace App\Api\V1\Providers;

use App\Common\Models\Book;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Route;

class BookServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Route::bind('book', function (int $bookId) {
            return Book::where('id', $bookId)->where('publisher_id', Auth::user()->id)->firstOrFail();
        });
    }
}

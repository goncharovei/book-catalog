<?php

use App\Front\Publisher\Http\Controllers\CabinetController;
use Illuminate\Support\Facades\Route;

Route::namespace('App\Front\Publisher\Http\Controllers')->group(function (){
    Auth::routes();
});

Route::get('cabinet', [CabinetController::class, 'index'])->name('publisher.cabinet.index');

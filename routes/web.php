<?php

use App\Http\Controllers\ValentineController;
use Illuminate\Support\Facades\Route;



Route::get('/', function () {
    return view('valentine');
});


Route::post('/save-valentine', [ValentineController::class, 'store']);
Route::get('/valentine', [ValentineController::class, 'show']);

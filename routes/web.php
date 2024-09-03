<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WorkSessionController;

Route::post('/start', [WorkSessionController::class, 'startSession']);
Route::post('/end/{id}', [WorkSessionController::class, 'endSession']);
Route::get('/sessions', [WorkSessionController::class, 'getSessions']);
Route::get('/', function () {
    return view('welcome');
});
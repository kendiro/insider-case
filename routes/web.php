<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', [\App\Http\Controllers\FixtureController::class, 'team']);
Route::get('/fixtures', [\App\Http\Controllers\FixtureController::class, 'index']);
Route::get('/simulation', [\App\Http\Controllers\FixtureController::class, 'simulation']);
Route::get('/simulate', [\App\Http\Controllers\FixtureController::class, 'simulate']);

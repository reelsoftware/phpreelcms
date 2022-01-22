<?php

use App\Http\Controllers\SeasonController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SeriesController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

// Series
Route::get('series/', [SeriesController::class, 'index']);
Route::get('series/{id}', [SeriesController::class, 'show']);

// Seasons
Route::get('seasons/', [SeasonController::class, 'index'])->name('seasonsIndex');

Route::fallback(function() {
    return response()->json(['error' => 'Server error. Something went wrong.'], 500); 
});
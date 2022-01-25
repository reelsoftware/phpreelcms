<?php

use App\Http\Controllers\EpisodeController;
use App\Http\Controllers\SeasonController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SeriesController;
use App\Http\Controllers\ResourceController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\SubscriptionController;
use App\Http\Controllers\UserController;

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

// Series
Route::middleware(['auth:sanctum'])->group(function () 
{
    Route::get('series/{id}', [SeriesController::class, 'show']);

    Route::get('/subscribe', [SubscriptionController::class, 'index'])->name('subscribe');
    Route::post('/subscribe/store', [SubscriptionController::class, 'store'])->name('subscribeStore');

});

Route::get('series', [SeriesController::class, 'index']);

// Seasons
Route::get('seasons', [SeasonController::class, 'index'])->name('seasonsIndex');

//Episodes
Route::get('episodes', [EpisodeController::class, 'index'])->name('episodeIndex');
Route::get('episodes/{id}', [EpisodeController::class, 'show'])->name('episodeShow:api');

//Resources
Route::get('/resource/video/{storage}/{fileName}', [ResourceController::class, 'videoFile'])->name('videoResource');

// Authentication
Route::post('register', [RegisterController::class, 'register']);
Route::post('login', [RegisterController::class, 'login']);

Route::post('/user/subscription', [UserController::class, 'manageSubscription'])->name('userManageSubscription');


//Test route
Route::middleware('auth:sanctum')->get('/testtttt', function() {
    return response()->json('Ok, you got credentials.', 200); 
});

Route::fallback(function() {
    return response()->json(['error' => 'Server error. Something went wrong.'], 500); 
});
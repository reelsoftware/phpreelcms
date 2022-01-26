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

// Subscribe
Route::get('/subscribe', [SubscriptionController::class, 'index'])->name('subscribe');

Route::middleware(['auth:sanctum'])->group(function () 
{


    // Subscribe
    Route::post('/subscribe/store', [SubscriptionController::class, 'store'])->name('subscribeStore');

    // User settings
    Route::post('/user/subscription', [UserController::class, 'manageSubscription'])->name('userManageSubscription');
});




// Episodes
Route::get('episodes', [EpisodeController::class, 'index'])->name('episodeIndex');
Route::get('episodes/{id}', [EpisodeController::class, 'show'])->name('episodeShow:api');

// Series

/**
 * Get a paginated list of all the publicly available series.
 * URL parameters:
 * @param perPage int how many entries to be displayed at once on one page.
 * @param pagination string either normal or simple for simple pagination.
 */
Route::get('series', [SeriesController::class, 'index'])->name('seriesIndex:api');

/**
 * Get a single publicly available series.
 * URL parameters:
 * @param id int unique id of the requested series.
 */
Route::get('series/{id}', [SeriesController::class, 'show'])->name('seriesShow:api');

// Seasons

/**
 * Get a single season linked to a particular publicly available series defined by an unique series-id.
 * URL parameters:
 * @param series-id int unique id of the series that is linked to the requested season.
 */
Route::get('seasons', [SeasonController::class, 'index'])->name('seasonsIndex:api');

Route::middleware(['access.availability'])->group(function () 
{
    // Resources
    Route::get('/resource/video/{storage}/{fileName}', [ResourceController::class, 'videoFile'])->name('videoResource');
});

// Authentication
Route::post('register', [RegisterController::class, 'register'])->name('register:api');
Route::post('login', [RegisterController::class, 'login'])->name('login:api');

/*
Route::fallback(function() {
    return response()->json(['error' => 'Server error. Something went wrong.'], 500); 
});
*/
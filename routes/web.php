<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Http\Controllers\SubscriptionController;
use App\Http\Controllers\MovieController;
use App\Http\Controllers\SubscriptionTypesController;
use App\Http\Controllers\SubscriptionPlansController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\InstallController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\SeriesController;
use App\Http\Controllers\TranslationController;
use App\Http\Controllers\CategoriesController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\UserDashboardController;
use App\Http\Controllers\SeasonController;
use App\Http\Controllers\EpisodeController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\TrailerController;
use App\Http\Controllers\ResourceController;
use App\Http\Controllers\TranscodingController;
use App\Http\Controllers\ThemesController;
use App\Http\Controllers\AssetController;
use App\Http\Controllers\TestController;
use App\Http\Controllers\EpisodeOrderController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::middleware(['install'])->group(function () 
{
    Route::get('/install', [InstallController::class, 'index'])
        ->name('install');

    Route::get('/install/requirements', [InstallController::class, 'requirements'])
        ->name('installRequirements');

    Route::get('/install/config', [InstallController::class, 'config'])
        ->name('installConfig');

    Route::post('/install/config', [InstallController::class, 'storeConfig'])
        ->name('storeConfig');

    Route::get('/install/seed', [InstallController::class, 'seed'])
        ->name('installSeed');

    Route::post('/install/seed', [InstallController::class, 'storeSeed'])
        ->name('storeSeed');
});

//Asset routes
Route::get('/asset/js/{scriptName}', [AssetController::class, 'javascript'])
    ->name('jsAsset');

Route::get('/asset/css/{styleName}', [AssetController::class, 'css'])
    ->name('cssAsset');

Route::get('/asset/image/{imageName}', [AssetController::class, 'image'])
    ->name('imageAsset');

Route::middleware(['setLanguage'])->group(function () 
{
    Route::get('/', [HomeController::class, 'index'])
            ->name('home');

    require __DIR__.'/auth.php';

    //Resources
    Route::get('/resource/video/{storage}/{fileName}', [ResourceController::class, 'file'])
        ->middleware('access.availability')
        ->name('fileResource');

    Route::get('/resource/image/{storage}/{fileName}', [ResourceController::class, 'imageFile'])->name('fileResourceImage');

    //Categories
    Route::get('/categories', [CategoriesController::class, 'index'])->name('categories');

    Route::get('/categories/cast/{slug}', [CategoriesController::class, 'showCast'])
        ->name('castShow');

    Route::get('/categories/genre/{slug}', [CategoriesController::class, 'showGenre'])
        ->name('genreShow');

    Route::get('/categories/release/{year}', [CategoriesController::class, 'showRelease'])
        ->name('releaseShow');

    Route::get('/categories/rating/{grade}', [CategoriesController::class, 'showRating'])
        ->name('ratingShow');

    //Subscriptions
    Route::get('/subscribe', [SubscriptionController::class, 'index'])->name('subscribe');

    //Search
    Route::get('/search/{query}', [SearchController::class, 'index'])->name('search');
    Route::post('/search/', [SearchController::class, 'search'])->name('searchPost');

    //Movies
    Route::get('/movies', [MovieController::class, 'index'])
        ->name('movies');

    //Series
    Route::get('/series', [SeriesController::class, 'index'])
        ->name('series');

    Route::get('/series/{id}', [SeriesController::class, 'show'])
        ->name('seriesShow');

    //Trailer
    Route::get('/trailer/movie/{id}', [TrailerController::class, 'showMovie'])
        ->name('trailerMovieShow');

    Route::get('/trailer/season/{id}', [TrailerController::class, 'showSeason'])
        ->name('trailerSeasonShow');

    //Check if the content is free and if requires auth
    Route::middleware(['access.availability'])->group(function () 
    {
        Route::get('/movie/{id}', [MovieController::class, 'show'])
            ->name('movieShow');

        //Episodes
        Route::get('/episode/{id}', [EpisodeController::class, 'show'])
            ->name('episodeShow');
    });

    Route::middleware(['auth'])->group(function () 
    {
        //Users
        Route::get('/user', [UserController::class, 'index'])->name('user');

        Route::post('/user/update', [UserController::class, 'update'])
            ->name('userUpdate');

        Route::post('/user/update/language', [UserController::class, 'updateLanguage'])
            ->name('userUpdateLanguage');

        //Subscriptions
        Route::get('/user/invoice/{invoice}', [UserController::class, 'invoice']);

        Route::post('/subscribe/create', [SubscriptionController::class, 'create'])
        ->name('subscribeCreate');

        Route::post('/subscribe/store', [SubscriptionController::class, 'store'])
            ->name('subscribeStore');

        Route::middleware(['subscribed'])->group(function () 
        {
            Route::get('/subscribe/edit', [SubscriptionController::class, 'edit'])
                ->name('subscribeEdit');

            Route::post('/subscribe/update', [SubscriptionController::class, 'update'])
                ->name('subscribeUpdate');

            Route::get('/subscribe/cancel', [SubscriptionController::class, 'destroy'])
                ->name('subscribeCancel');

            Route::get('/subscribe/result', [SubscriptionController::class, 'result'])
                ->name('subscriptionResult');
        });
});
    //Admin dashboard routes
    Route::middleware(['admin', 'auth'])->group(function () 
    {
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

        //Upload API
        Route::post('dashboard/api/store', [ResourceController::class, 'storeAPI'])
            ->name('resourceStoreApi');

        //Movie
        Route::get('dashboard/movie', [MovieController::class, 'indexDashboard'])
            ->name('movieDashboard');

        Route::get('dashboard/movie/create', [MovieController::class, 'create'])
            ->name('movieCreate');

        Route::post('dashboard/movie/store', [MovieController::class, 'store'])
            ->name('movieStore');

        Route::get('dashboard/movie/edit/{id}', [MovieController::class, 'edit'])
            ->name('movieEdit');

        Route::post('dashboard/movie/update/{id}', [MovieController::class, 'update'])
            ->name('movieUpdate');

        //Series
        Route::get('dashboard/series', [SeriesController::class, 'indexDashboard'])
        ->name('seriesDashboard');

        Route::get('dashboard/series/create', [SeriesController::class, 'create'])
            ->name('seriesCreate');

        Route::post('dashboard/series/store', [SeriesController::class, 'store'])
            ->name('seriesStore');

        Route::get('dashboard/series/edit/{id}', [SeriesController::class, 'edit'])
            ->name('seriesEdit');

        Route::post('dashboard/series/update/{id}', [SeriesController::class, 'update'])
            ->name('seriesUpdate');

        //Season
        Route::get('dashboard/season', [SeasonController::class, 'indexDashboard'])
            ->name('seasonDashboard');

        Route::get('dashboard/season/create', [SeasonController::class, 'create'])
            ->name('seasonCreate');

        Route::post('dashboard/season/store', [SeasonController::class, 'store'])
            ->name('seasonStore');

        Route::get('dashboard/season/edit/{id}', [SeasonController::class, 'edit'])
            ->name('seasonEdit');

        Route::post('dashboard/season/update/{id}', [SeasonController::class, 'update'])
            ->name('seasonUpdate');

        Route::get('dashboard/season/order/{id}', [SeasonController::class, 'seasonsOrderEdit'])
            ->name('seasonsOrderEdit');

        Route::post('dashboard/season/order/{id}', [SeasonController::class, 'seasonsOrderUpdate'])
            ->name('seasonsOrderUpdate');

        //Episode
        Route::get('dashboard/episode', [EpisodeController::class, 'indexDashboard'])
            ->name('episodeDashboard');

        Route::get('dashboard/episode/create', [EpisodeController::class, 'create'])
            ->name('episodeCreate');

        Route::post('dashboard/episode/store', [EpisodeController::class, 'store'])
            ->name('episodeStore');

        Route::get('dashboard/episode/edit/{id}', [EpisodeController::class, 'edit'])
            ->name('episodeEdit');

        Route::post('dashboard/episode/update/{id}', [EpisodeController::class, 'update'])
            ->name('episodeUpdate');

        Route::get('dashboard/episode/order/{id}', [EpisodeOrderController::class, 'edit'])
            ->name('episodesOrderEdit');

        Route::post('dashboard/episode/order/{id}', [EpisodeOrderController::class, 'update'])
            ->name('episodesOrderUpdate');

        Route::middleware(['stripe'])->group(function () 
        {
            //Subscription plans   
            Route::get('dashboard/subscription/plan', [SubscriptionPlansController::class, 'index'])
                ->name('subscriptionPlan');

            Route::get('dashboard/subscription/plan/create', [SubscriptionPlansController::class, 'create'])
                ->name('subscriptionPlanCreate');

            Route::post('dashboard/subscription/plan/store', [SubscriptionPlansController::class, 'store'])
                ->name('subscriptionPlanStore');
                       
            Route::get('dashboard/subscription/plan/edit/{id}', [SubscriptionPlansController::class, 'edit'])
                ->name('subscriptionPlanEdit');

            Route::post('dashboard/subscription/plan/update/{id}', [SubscriptionPlansController::class, 'update'])
                ->name('subscriptionPlanUpdate');
        });

        //Settings

        Route::get('dashboard/settings/storage', [SettingsController::class, 'storage'])
            ->name('settingsStorage');

        Route::post('dashboard/settings/storage', [SettingsController::class, 'storageStore'])
            ->name('storageStore');

        Route::get('dashboard/settings/version', [SettingsController::class, 'version'])
            ->name('settingsVersion');

        Route::get('dashboard/settings/version/update', [SettingsController::class, 'versionUpdate'])
            ->name('versionUpdate');

        Route::get('dashboard/settings/app', [SettingsController::class, 'app'])
            ->name('settingsApp');

        Route::post('dashboard/settings/app', [SettingsController::class, 'appUpdate'])
            ->name('appUpdate');

        Route::get('dashboard/settings/email', [SettingsController::class, 'email'])
            ->name('settingsEmail');

        Route::post('dashboard/settings/email', [SettingsController::class, 'emailUpdate'])
            ->name('emailUpdate');

        Route::get('dashboard/settings/stripe', [SettingsController::class, 'stripe'])
            ->name('settingsStripe');

        Route::post('dashboard/settings/stripe', [SettingsController::class, 'stripeUpdate'])
            ->name('stripeUpdate');

        //Translation
        Route::get('dashboard/translation', [TranslationController::class, 'index'])
            ->name('translationDashboard');

        Route::get('dashboard/translation/create', [TranslationController::class, 'create'])
            ->name('translationCreate');

        Route::post('dashboard/translation/store', [TranslationController::class, 'store'])
            ->name('translationStore');

        Route::get('dashboard/translation/edit/{id}', [TranslationController::class, 'edit'])
            ->name('translationEdit');

        Route::post('dashboard/translation/update/{id}', [TranslationController::class, 'update'])
            ->name('translationUpdate');

        Route::get('dashboard/translation/delete/{id}', [TranslationController::class, 'destroy'])
            ->name('translationDestroy');

        //Users
        Route::get('dashboard/users', [UserDashboardController::class, 'index'])
            ->name('usersDashboard');

        Route::get('dashboard/users/edit/{id}', [UserDashboardController::class, 'edit'])
            ->name('usersEdit');

        Route::post('dashboard/users/update/{id}', [UserDashboardController::class, 'update'])
            ->name('usersUpdate');

        Route::get('dashboard/users/subscription/{id}', [UserDashboardController::class, 'subscriptionDetails'])
            ->name('usersSubscriptionDetails');

        //Themes
        Route::get('dashboard/themes', [ThemesController::class, 'index'])
            ->name('themeIndex');

        Route::get('/dashboard/themes/cover/{theme}', [ThemesController::class, 'cover'])
            ->name('themeCover');

        Route::post('dashboard/themes', [ThemesController::class, 'update'])
            ->name('themeUpdate');

        Route::post('dashboard/themes/destroy', [ThemesController::class, 'destroy'])
            ->name('themeDestroy');
    });
});




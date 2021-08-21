<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Menu;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Menu::create('dashboard-nav', function($menu) {
            $menu->dropdown('Standalone videos', function ($sub) {
                $sub->route('videoDashboard', 'Show all', [], ['icon' => 'ni ni-image']);
                $sub->route('videoCreate', 'Create new', [], ['icon' => 'ni ni-fat-add']);
            });

            $menu->dropdown('Movies', function ($sub) {
                $sub->route('movieDashboard', 'Show all', [], ['icon' => 'ni ni-image']);
                $sub->route('movieCreate', 'Create new', [], ['icon' => 'ni ni-fat-add']);
            });

            $menu->dropdown('Series', function ($sub) {
                $sub->route('seriesDashboard', 'Show all', [], ['icon' => 'ni ni-image']);
                $sub->route('seriesCreate', 'Create new', [], ['icon' => 'ni ni-fat-add']);
            });

            $menu->dropdown('Seasons', function ($sub) {
                $sub->route('seasonDashboard', 'Show all', [], ['icon' => 'ni ni-image']);
                $sub->route('seasonCreate', 'Create new', [], ['icon' => 'ni ni-fat-add']);
            });

            $menu->dropdown('Episodes', function ($sub) {
                $sub->route('episodeDashboard', 'Show all', [], ['icon' => 'ni ni-image']);
                $sub->route('episodeCreate', 'Create new', [], ['icon' => 'ni ni-fat-add']);
            });

            $menu->dropdown('Subscription plans', function ($sub) {
                $sub->route('subscriptionPlan', 'Show all', [], ['icon' => 'ni ni-image']);
                $sub->route('subscriptionPlanCreate', 'Create new', [], ['icon' => 'ni ni-fat-add']);
            });

            $menu->dropdown('Themes', function ($sub) {
                $sub->route('themeIndex', 'Show all', [], ['icon' => 'ni ni-ruler-pencil']);
            });

            $menu->dropdown('Modules', function ($sub) {
                $sub->route('moduleIndex', 'Show all', [], ['icon' => 'ni ni-box-2']);
            });

            $menu->dropdown('Translation', function ($sub) {
                $sub->route('translationDashboard', 'Show all', [], ['icon' => 'ni ni-image']);
                $sub->route('translationCreate', 'Create new', [], ['icon' => 'ni ni-fat-add']);
            });

            $menu->dropdown('Users', function ($sub) {
                $sub->route('usersDashboard', 'Show all', [], ['icon' => 'ni ni-badge']);
            });
            
            $menu->dropdown('Settings', function ($sub) {
                $sub->route('settingsStorage', 'Storage', [], ['icon' => 'ni ni-archive-2']);
                $sub->route('settingsVersion', 'Version', [], ['icon' => 'ni ni-air-baloon']);
                $sub->route('settingsEmail', 'Email', [], ['icon' => 'ni ni-email-83']);
                $sub->route('settingsStripe', 'Stripe', [], ['icon' => 'ni ni-cart']);
                $sub->route('settingsApp', 'App', [], ['icon' => 'ni ni-settings-gear-65']);
            });
        });
        
        Paginator::useBootstrap();
        Schema::defaultStringLength(191);

        /**
         * Paginate a standard Laravel Collection.
         *
         * @param int $perPage
         * @param int $total
         * @param int $page
         * @param string $pageName
         * @return array
         */
        Collection::macro('paginate', function($perPage, $total = null, $page = null, $pageName = 'page') {
            $page = $page ?: LengthAwarePaginator::resolveCurrentPage($pageName);

            return new LengthAwarePaginator(
                $this->forPage($page, $perPage),
                $total ?: $this->count(),
                $perPage,
                $page,
                [
                    'path' => LengthAwarePaginator::resolveCurrentPath(),
                    'pageName' => $pageName,
                ]
            );
        });
    }
}

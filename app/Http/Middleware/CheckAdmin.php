<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Menu;

class CheckAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        Menu::create('movies', function($menu) {
            $menu->header('Movies');
            $menu->route('movieDashboard', 'Show all', [], ['icon' => 'ni ni-image']);
            $menu->route('movieCreate', 'Create new', [], ['icon' => 'ni ni-fat-add']);
        });

        Menu::create('series', function($menu) {
            $menu->header('Series');
            $menu->route('seriesDashboard', 'Show all', [], ['icon' => 'ni ni-image']);
            $menu->route('seriesCreate', 'Create new', [], ['icon' => 'ni ni-fat-add']);
        });

        Menu::create('seasons', function($menu) {
            $menu->header('Seasons');
            $menu->route('seasonDashboard', 'Show all', [], ['icon' => 'ni ni-image']);
            $menu->route('seasonCreate', 'Create new', [], ['icon' => 'ni ni-fat-add']);
        });

        Menu::create('episodes', function($menu) {
            $menu->header('Episodes');
            $menu->route('episodeDashboard', 'Show all', [], ['icon' => 'ni ni-image']);
            $menu->route('episodeCreate', 'Create new', [], ['icon' => 'ni ni-fat-add']);
        });

        Menu::create('subscriptionPlan', function($menu) {
            $menu->header('Subscription plans');
            $menu->route('subscriptionPlan', 'Show all', [], ['icon' => 'ni ni-image']);
            $menu->route('subscriptionPlanCreate', 'Create new', [], ['icon' => 'ni ni-fat-add']);
        });

        Menu::create('themes', function($menu) {
            $menu->header('Themes');
            $menu->route('themeIndex', 'Show all', [], ['icon' => 'ni ni-image']);
        });

        Menu::create('translation', function($menu) {
            $menu->header('Translation');
            $menu->route('translationDashboard', 'Show all', [], ['icon' => 'ni ni-image']);
            $menu->route('translationCreate', 'Create new', [], ['icon' => 'ni ni-fat-add']);
        });

        Menu::create('users', function($menu) {
            $menu->header('Users');
            $menu->route('usersDashboard', 'Show all', [], ['icon' => 'ni ni-badge']);
        });

        Menu::create('settings', function($menu) {
            $menu->header('Settings');
            $menu->route('settingsStorage', 'Storage', [], ['icon' => 'ni ni-archive-2']);
            $menu->route('settingsVersion', 'Version', [], ['icon' => 'ni ni-air-baloon']);
            $menu->route('settingsEmail', 'Email', [], ['icon' => 'ni ni-email-83']);
            $menu->route('settingsStripe', 'Stripe', [], ['icon' => 'ni ni-cart']);
            $menu->route('settingsApp', 'App', [], ['icon' => 'ni ni-settings-gear-65']);
        });

        if ($request->user() && $request->user()->roles != 'admin') 
        {
            return redirect('/');
        }

        return $next($request);
    }
}

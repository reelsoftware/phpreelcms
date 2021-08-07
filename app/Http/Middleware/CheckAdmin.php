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
         Menu::create('dashboard-nav', function($menu) {
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

        if ($request->user() && $request->user()->roles != 'admin') 
        {
            return redirect('/');
        }

        return $next($request);
    }
}

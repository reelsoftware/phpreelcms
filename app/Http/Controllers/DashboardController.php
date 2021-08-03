<?php

namespace App\Http\Controllers;

use DB;
use App\Models\User;
use Carbon\Carbon;
use App\Helpers\Menu\MenuBuilder;
use Menu;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        Menu::create('navbar', function($menu) {
            $menu->url('/', 'Home')->order(1);
            $menu->route('/', 'About', ['user' => '1'], ['icon' => 'fa fa-user'])->order(0);
            $menu->dropdown('Account', function ($sub) {
                $sub->url('profile', 'Visit My Profile');
                $sub->dropdown('Settings', function ($sub) {
                    $sub->url('settings/password', 'Password');
                    $sub->url('settings/design', 'Design');
                });
                $sub->url('logout', 'Logout');
            })->order(2);
        });

        $menuCollection = Menu::sort('navbar');

        //dd($menuCollection);

        dd($menuCollection);

        return view('test', [
            'test' => Menu::convert('navbar')
        ]);




        $menu = new MenuBuilder();
        $result = $menu
            ->add("Home", route('home'), 2)
            ->add("M", [
                "Test" => "abc",
                "Submenu" => [
                    "Menu" => "test"
                ],
            ], 1);

        $result->add("Home2", route('home'))->addAfter("Home3", route('home'), "Home");

        $result->append("M", [
            "ElemNou" => "el", 
            "Hahaha" => [
                "Abccccc" => 'xxxx'
            ]
        ]);


        dd($result->generate());
        //Count all users
        $usersCount = DB::table('users')->count();

        //Count all users by 30 days ago
        $usersCount30Days = DB::table('users')->where('created_at', '<', now()->subDays(30))->count();

        //Change in users
        if($usersCount30Days != 0)
            $percentageChangeUsers = (($usersCount - $usersCount30Days) / $usersCount30Days) * 100;
        else
            $percentageChangeUsers = 0;

        //Count all active subscribers
        $activeSubscription = DB::table('subscriptions')->where('ends_at', '=', null)->count();

        //Percentage of users that are subscribed
        if($usersCount != 0)
            $percentageSubscribed = (100 * $activeSubscription) / $usersCount;
        else
            $percentageSubscribed = 0;

        //Count all movies
        $moviesCount = DB::table('movies')->count();

        //Count all series
        $seriesCount = DB::table('series')->count();

        //Latest 10 users
        $latestUsers = DB::table('users')->orderBy('created_at', 'DESC')->limit(2)->get(['name', 'email', 'created_at']);

        return view('dashboard.index', [
            'usersCount' => $usersCount,
            'activeSubscription' => $activeSubscription,
            'percentageSubscribed' => $percentageSubscribed,
            'moviesCount' => $moviesCount,
            'seriesCount' => $seriesCount,
            'percentageChangeUsers' => $percentageChangeUsers,
            'latestUsers' => $latestUsers
        ]);
    }
}

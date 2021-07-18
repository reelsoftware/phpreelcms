<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Setting;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Auth\Events\Registered;
use App\Models\SubscriptionType;

class DevSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //Create a mock Stripe product and save it to the database
        $stripe = new \Stripe\StripeClient(env('STRIPE_SECRET'));
        $product = $stripe->products->create([
            'name' => 'default',
        ]);

        //Add subscription to the database
        $subscriptionType = new SubscriptionType();
        $subscriptionType->name = 'default';
        $subscriptionType->product_id = $product['id'];
        $subscriptionType->public = '1';
        $subscriptionType->save();

        //Create new admin user

        $user = User::create([
            'name' => "admin",
            'email' => "admin@paulbalan.com",
            'password' => Hash::make("123456789"),
        ]);

        Auth::login($user);

        event(new Registered($user));

        //Make admin
        $admin = User::where('email', '=', "admin@paulbalan.com")->first();
        $admin->roles = 'admin';
        $admin->save();

        //Add settings
        $settings = [
            ['setting' => 'default_subscription', 'value' => 'default'],
            ['setting' => 'company_name', 'value' => 'name']
        ];

        Setting::insert($settings);  
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SubscriptionPlan;
use App\Models\SubscriptionType;

class SubscriptionPlansController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $subscriptionPlans = SubscriptionPlan::orderByDesc('id')->simplePaginate(10);

        return view('subscriptionPlans.index', [
            'subscriptionPlans' => $subscriptionPlans, 
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $subscriptions = SubscriptionType::orderByDesc('id')->get(['id', 'name', 'product_id']);
        $currencies = [
            'USD', 'EUR', 'GBP', 'AED', 'AFN', 'ALL', 'AMD', 'ANG', 'AOA', 
            'ARS', 'AUD', 'AWG', 'AZN', 'BAM', 'BBD', 'BDT', 'BGN', 'BIF', 
            'BMD', 'BND', 'BOB', 'BRL', 'BSD', 'BWP', 'BZD', 'CAD', 'CDF', 
            'CHF', 'CLP', 'CNY', 'COP', 'CRC', 'CVE', 'CZK', 'DJF', 'DKK', 
            'DOP', 'DZD', 'EGP', 'ETB', 'FJD', 'FKP', 'GEL', 'GIP', 'GMD', 
            'GNF', 'GTQ', 'GYD', 'HKD', 'HNL', 'HRK', 'HTG', 'HUF', 'IDR', 
            'ILS', 'INR', 'ISK', 'JMD', 'JPY', 'KES', 'KGS', 'KHR', 'KMF', 
            'KRW', 'KYD', 'KZT', 'LAK', 'LBP', 'LKR', 'LRD', 'LSL', 'MAD', 
            'MDL', 'MGA', 'MKD', 'MMK', 'MNT', 'MOP', 'MRO', 'MUR', 'MVR', 
            'MWK', 'MXN', 'MYR', 'MZN', 'NAD', 'NGN', 'NIO', 'NOK', 'NPR', 
            'NZD', 'PAB', 'PEN', 'PGK', 'PHP', 'PKR', 'PLN', 'PYG', 'QAR', 
            'RON', 'RSD', 'RUB', 'RWF', 'SAR', 'SBD', 'SCR', 'SEK', 'SGD', 
            'SHP', 'SLL', 'SOS', 'SRD', 'STD', 'SZL', 'THB', 'TJS', 'TOP', 
            'TRY', 'TTD', 'TWD', 'TZS', 'UAH', 'UGX', 'UYU', 'UZS', 'VND', 
            'VUV', 'WST', 'XAF', 'XCD', 'XOF', 'XPF', 'YER', 'ZAR', 'ZMW'
        ];

        return view('subscriptionPlans.create', [
            'subscriptions' => $subscriptions,
            'currencies' => $currencies,
        ]);
    }

    private function toPennies($value): int
    {
        return (int) (string) ((float) preg_replace("/[^0-9.]/", "", $value) * 100);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validated = $request->validate( [
            'name' => 'required|max:25',
            'description' => 'required|max:255',
            'benefits' => 'required|max:500',
            'price' => 'required|max:25',
            'currency' => 'required',
            'public' => 'required|boolean',
            'billingInterval' => 'required|max:10',
        ]);

        $pennies = self::toPennies($request->price);
        $subscription = SubscriptionType::where('name', '=', 'default')
            ->first(['product_id', 'id']);

        //Add plan to Stripe
        $stripe = new \Stripe\StripeClient(env('STRIPE_SECRET'));
        $price = $stripe->prices->create([
            'unit_amount' => $pennies,
            'currency' => strtolower($request->currency),
            'recurring' => ['interval' => $request->billingInterval],
            'product' => $subscription['product_id'],
        ]);
        
        //Add plan to database
        $subscriptionPlan = new SubscriptionPlan();
        $subscriptionPlan->name = $request->name;
        $subscriptionPlan->description = $request->description;
        $subscriptionPlan->stripe_price_id = $price['id'];
        $subscriptionPlan->benefits = $request->benefits;
        $subscriptionPlan->price = $pennies;
        $subscriptionPlan->currency = $request->currency;
        $subscriptionPlan->subscription_type_id = $subscription['id'];
        $subscriptionPlan->billing_interval = $request->billingInterval;
        $subscriptionPlan->public = $request->public;
        $subscriptionPlan->save();

        return redirect()->route('subscriptionPlan');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $subscriptionPlan = SubscriptionPlan::find($id);
        $subscriptions = SubscriptionType::orderByDesc('id')->get(['id', 'name', 'product_id']);
        $currencies = ['USD', 'EUR', 'GBP', 'AED', 'AFN', 'ALL', 'AMD', 'ANG', 'AOA', 'ARS', 'AUD', 'AWG', 'AZN', 'BAM', 'BBD', 'BDT', 'BGN', 'BIF', 'BMD', 'BND', 'BOB', 'BRL', 'BSD', 'BWP', 'BZD', 'CAD', 'CDF', 'CHF', 'CLP', 'CNY', 'COP', 'CRC', 'CVE', 'CZK', 'DJF', 'DKK', 'DOP', 'DZD', 'EGP', 'ETB', 'FJD', 'FKP', 'GEL', 'GIP', 'GMD', 'GNF', 'GTQ', 'GYD', 'HKD', 'HNL', 'HRK', 'HTG', 'HUF', 'IDR', 'ILS', 'INR', 'ISK', 'JMD', 'JPY', 'KES', 'KGS', 'KHR', 'KMF', 'KRW', 'KYD', 'KZT', 'LAK', 'LBP', 'LKR', 'LRD', 'LSL', 'MAD', 'MDL', 'MGA', 'MKD', 'MMK', 'MNT', 'MOP', 'MRO', 'MUR', 'MVR', 'MWK', 'MXN', 'MYR', 'MZN', 'NAD', 'NGN', 'NIO', 'NOK', 'NPR', 'NZD', 'PAB', 'PEN', 'PGK', 'PHP', 'PKR', 'PLN', 'PYG', 'QAR', 'RON', 'RSD', 'RUB', 'RWF', 'SAR', 'SBD', 'SCR', 'SEK', 'SGD', 'SHP', 'SLL', 'SOS', 'SRD', 'STD', 'SZL', 'THB', 'TJS', 'TOP', 'TRY', 'TTD', 'TWD', 'TZS', 'UAH', 'UGX', 'UYU', 'UZS', 'VND', 'VUV', 'WST', 'XAF', 'XCD', 'XOF', 'XPF', 'YER', 'ZAR', 'ZMW'];
       
        if($subscriptionPlan != null)
            $content = $subscriptionPlan;
        else
            dd('Wrong id');

        return view('subscriptionPlans.edit', [
            'id' => $id,
            'content' => $content,
            'currencies' => $currencies,
            'subscriptions' => $subscriptions,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validated = $request->validate( [
            'name' => 'required|max:25',
            'description' => 'required|max:255',
            'benefits' => 'required|max:500',
            'public' => 'required|boolean',
        ]);

        //Add plan to database
        $subscriptionPlan = SubscriptionPlan::find($id);
        $subscriptionPlan->name = $request->name;
        $subscriptionPlan->description = $request->description;
        $subscriptionPlan->benefits = $request->benefits;
        $subscriptionPlan->public = $request->public;
        $subscriptionPlan->save();

        return redirect()->route('subscriptionPlan');
    }
}

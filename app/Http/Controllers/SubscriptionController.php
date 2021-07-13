<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SubscriptionPlan;
use App\Models\Setting;
use App\Helpers\PaymentProcessor\PaymentContext;
use App\Helpers\PaymentProcessor\CardStrategy;
use App\Helpers\Theme\Theme;
use App\Helpers\User\UserHandler;
use App\Helpers\Subscription\PlanHandler;
use Auth;

class SubscriptionController extends Controller
{
    public function __construct()
    {
        $this->paymentContext = new PaymentContext();   
    } 

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Auth::user();
        $benefits = [];
        
        $subscription = UserHandler::checkSubscription();

        $plans = PlanHandler::getPublicPlans();

        foreach($plans as $plan)
            $benefits[] = explode(',', $plan->benefits);

        return Theme::view('subscribe.index', [
            'plans' => $plans,
            'benefits' => $benefits,
            'subscription' => $subscription
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $validated = $request->validate( [
            'plan' => 'required',
            'price' => 'required',
            'currency' => 'required',
            'planName' => 'required',
        ]);

        $user = Auth::user();

        if(!$user->subscribed('default'))
            return Theme::view('subscribe.create', [
                'intent' => $user->createSetupIntent(),
                'name' => $request->plan,
                'price' => $request->price,
                'currency' => $request->currency,
                'planName' => $request->planName,
            ]);
        else
            return redirect(route('home'));
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
            'plan' => 'required',
        ]);

        $this->paymentContext->setPaymentStrategy(new CardStrategy($request));

        $success = $this->paymentContext->execute();

        return Theme::view('subscribe.result', [
            'success' => $success
        ]);
    }

    public function result()
    {
        return Theme::view('subscribe.result', [
            'success' => $success
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit()
    {
        $user = Auth::user();

        $invoices = $user->invoices();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy()
    {
        $user = Auth::user();
        $defaultSubscription = Setting::where('setting', '=', 'default_subscription')->first()['value'];

        $user->subscription($defaultSubscription)->cancel();

        return redirect(route('user'));
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SubscriptionPlan;
use App\Models\Setting;
use App\Helpers\PaymentProcessor\PaymentContext;
use App\Helpers\PaymentProcessor\CardStrategy;
use App\Helpers\Theme\Theme;
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
        
        if($user != null)
        {
            $defaultSubscription = 'default';
            $subscription = $user->subscribed($defaultSubscription);
        }
        else
        {
            $subscription = false;
        }

        $plans = Setting::where('setting', '=', 'default_subscription')
            ->join('subscription_types', 'subscription_types.name', '=', 'settings.value')
            ->join('subscription_plans', 'subscription_plans.subscription_type_id', '=', 'subscription_types.id')
            ->where('subscription_plans.public', '=', 1)
            ->get()->toArray();

            dd($plans);

        foreach($plans as $plan)
        {
            
        }

        //TO DO Check if benefits can have empty fields
        $benefits = explode(',', $plans->benefits);

        return view('subscribe.index', [
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

        return view(env('THEME') . '.subscribe.result', [
            'success' => $success
        ]);
    }

    public function result()
    {
        return view(env('THEME') . '.subscribe.result', [
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

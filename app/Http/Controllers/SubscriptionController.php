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
use App\Helpers\SubscriptionProcessor\SubscriptionContext;
use App\Helpers\SubscriptionProcessor\StripeStrategy;
use Auth;

class SubscriptionController extends Controller
{
    public function __construct()
    {
        $this->subscriptionContext = new SubscriptionContext(); 
    } 

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->subscriptionContext->setSubscriptionStrategy(new StripeStrategy());
        $response = $this->subscriptionContext->index();
        
        return response()->json($response, 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->subscriptionContext->setSubscriptionStrategy(new StripeStrategy([
            'request' => $request
        ]));
        
        $response = $this->subscriptionContext->store();
        return response()->json($response, 200);
    }
}

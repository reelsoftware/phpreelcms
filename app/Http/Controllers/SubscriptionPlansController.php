<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SubscriptionPlan;
use App\Models\SubscriptionType;
use App\Helpers\Payments\PaymentHelper;
use App\Helpers\PlansProcessor\PlanStrategy;
use App\Helpers\PlansProcessor\PlanContext;
use App\Helpers\PlansProcessor\StripeStrategy;


class SubscriptionPlansController extends Controller
{
    public function __construct()
    {
        $this->planContext = new PlanContext(); 
    } 

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->planContext->setPlanStrategy(new StripeStrategy());
        $view = $this->planContext->index();

        return view($view['name'], $view['data']);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->planContext->setPlanStrategy(new StripeStrategy());
        $view = $this->planContext->create();

        return view($view['name'], $view['data']);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->planContext->setPlanStrategy(new StripeStrategy([
            'request' => $request
        ]));
        $this->planContext->store();

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
        $this->planContext->setPlanStrategy(new StripeStrategy([
            'id' => $id
        ]));
        $view = $this->planContext->edit();

        return view($view['name'], $view['data']);
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
        $this->planContext->setPlanStrategy(new StripeStrategy([
            'request' => $request,
            'id' => $id
        ]));
        $view = $this->planContext->update();

        return redirect()->route('subscriptionPlan');
    }
}

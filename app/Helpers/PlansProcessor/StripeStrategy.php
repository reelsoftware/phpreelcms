<?php
namespace App\Helpers\PlansProcessor; 

use Illuminate\Http\Request;
use App\Helpers\PlansProcessor\IPlanStrategy;
use App\Helpers\Payments\PaymentHelper;
use App\Models\SubscriptionPlan;
use App\Models\SubscriptionType;

/**
 * Concrete strategy class used to work with Stripe
 */
class StripeStrategy implements IPlanStrategy
{
    /**
     * @var Request request object from the controller
     */
    private $request;

    /**
     * @var int id of a resource
     */
    private $id;

    public function __construct($params = null)
    {
        if($params !== null)
        {
            if(isset($params['request']) && $params['request'] !== null)
                $this->request = $request;

            if(isset($params['id']) && $params['id'] !== null)
                $this->id = $id;
        }
    }

    /**
     * Get all the data required to render the appropriate view
     *
     * @return array
     */
    public function index()
    {
        $subscriptionPlans = SubscriptionPlan::orderByDesc('id')->simplePaginate(10);

        $view = [];

        $view['name'] = 'subscriptionPlans.index';
        $view['data'] = [
            'subscriptionPlans' => $subscriptionPlans, 
        ];

        return $view;
    }

    /**
     * Get all the data required to render the appropriate view
     *
     * @return array 
     */
    public function create()
    {
        $subscriptions = SubscriptionType::orderByDesc('id')->get(['id', 'name', 'product_id']);
        $currencies = PaymentHelper::getCurrencies();

        $view = [];

        $view['name'] = 'subscriptionPlans.create';
        $view['data'] = [
            'subscriptions' => $subscriptions,
            'currencies' => $currencies,
        ];

        return $view;
    }

    /**
     * Implementation of the store method from the interface
     */
    public function store()
    {
        $this->request->validate( [
            'name' => 'required|max:25',
            'description' => 'required|max:255',
            'benefits' => 'required|max:500',
            'price' => 'required|max:25',
            'currency' => 'required',
            'public' => 'required|boolean',
            'billingInterval' => 'required|max:10',
        ]);

        $pennies = PaymentHelper::toPennies($request->price);
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
    }

    /**
     * Get all the data required to render the appropriate view
     *
     * @return string
     */
    public function edit()
    {
        $subscriptionPlan = SubscriptionPlan::find($this->id);
        $subscriptions = SubscriptionType::orderByDesc('id')->get(['id', 'name', 'product_id']);
        $currencies = PaymentHelper::getCurrencies();
       
        if($subscriptionPlan == null)
            abort(404);

        $view = [];

        $view['name'] = 'subscriptionPlans.edit';
        $view['data'] = [
            'id' => $id,
            'content' => $subscriptionPlan,
            'currencies' => $currencies,
            'subscriptions' => $subscriptions,
        ];
        
        return $view;
    }

    /**
     * Update the specified resource in storage.
     * 
     */
    public function update()
    {
        $this->request->validate( [
            'name' => 'required|max:25',
            'description' => 'required|max:255',
            'benefits' => 'required|max:500',
            'public' => 'required|boolean',
        ]);

        //Add plan to database
        $subscriptionPlan = SubscriptionPlan::find($this->id);
        $subscriptionPlan->name = $request->name;
        $subscriptionPlan->description = $request->description;
        $subscriptionPlan->benefits = $request->benefits;
        $subscriptionPlan->public = $request->public;
        $subscriptionPlan->save();
    }
}
<?php
namespace App\Helpers\SubscriptionProcessor; 

use Illuminate\Http\Request;
use App\Helpers\SubscriptionProcessor\ISubscriptionStrategy;
use App\Helpers\Payments\PaymentHelper;
use App\Models\SubscriptionPlan;
use App\Models\SubscriptionType;
use App\Helpers\User\UserHandler;
use App\Helpers\Subscription\PlanHandler;
use Auth;
use App\Helpers\PaymentProcessor\PaymentContext;
use App\Helpers\PaymentProcessor\CardStrategy;

/**
 * Concrete strategy class used to work with Stripe
 */
class StripeStrategy implements ISubscriptionStrategy
{
    /**
     * @var Request request object from the controller
     */
    private $request;

    /**
     * @var int id of a resource
     */
    private $id;

    /**
     * @var IPaymentContext defines a context for payments
     */
    private $paymentContext;

    public function __construct($params = null)
    {
        if($params !== null)
        {
            if(isset($params['request']) && $params['request'] !== null)
                $this->request = $params['request'];

            if(isset($params['id']) && $params['id'] !== null)
                $this->id = $params['id'];
        }

        $this->paymentContext = new PaymentContext();
    }

    /**
     * Get all the data required to render the appropriate view
     *
     * @return array
     */
    public function index()
    {
        $user = Auth::user();
        $benefits = [];
        
        $subscription = UserHandler::checkSubscription();

        $plans = PlanHandler::getPublicPlans();

        foreach($plans as $plan)
            $benefits[] = explode(',', $plan->benefits);

        $view = [];

        $view['name'] = 'subscribe.index';
        $view['data'] = [
            'plans' => $plans,
            'benefits' => $benefits,
            'subscription' => $subscription
        ];

        return $view;
    }


    /**
     * Implementation of the store method from the interface
     */
    public function store()
    {
        $this->paymentContext->setPaymentStrategy(new CardStrategy($this->request));

        $this->paymentContext->execute();
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
        $subscriptionPlan->name = $this->request->name;
        $subscriptionPlan->description = $this->request->description;
        $subscriptionPlan->benefits = $this->request->benefits;
        $subscriptionPlan->public = $this->request->public;
        $subscriptionPlan->save();
    }
}
<?php
namespace App\Helpers\PaymentProcessor; 
use App\Helpers\PaymentProcessor\IPaymentStrategy;

/**
 * Concrete strategy class implement the payment method while following the base Strategy
 * interface. The interface makes them interchangeable in the PaymentContext.
 */
class CardStrategy implements IPaymentStrategy
{
    /**
     * @var Request request object from the controller
     */
    private $request;

    public function __construct($request)
    {
        $this->request = $request;
    }

    /**
     * Implementation of the pay method from the interface
     */
    public function pay()
    {
        $this->request->validate( [
            'plan' => 'required'
        ]);

        $stripeCheckout = $this->request->user()
            ->newSubscription('default', $this->request->plan)
            ->checkout([
                'cancel_url' => route('subscribe'),
            ]);

        return redirect()->away($stripeCheckout->url);
    }
}
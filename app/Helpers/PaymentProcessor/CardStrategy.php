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
    public function pay(): bool
    {
        //Handler for the logged in user
        $user = $this->request->user();
        //Variable used by Stripe to charge the user
        $paymentMethod =  $this->request->input('payment_method');
        
        //Check if the user is not already subscribed
        if(!$user->subscribed('default'))
        {
            try 
            {
                //Create the Stripe customer
                $user->createOrGetStripeCustomer();
                //Set the default payment method for the user
                $user->updateDefaultPaymentMethod($paymentMethod);
                //Create the new subscription for the specific user
                $user->newSubscription('default', $this->request->plan)->create($this->request->paymentMethodId);        
            } 
            catch (Exception $exception) 
            {
                //Returns false if something fails
                return false;
            }
        }
        else
        {
            //Returns false if the user is already subscribed
            return false;
        }
        
        //Returns true if the payment is complete
        return true;
    }
}
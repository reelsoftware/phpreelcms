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
     * 
     */
    public function pay()
    {
        $this->request->validate( [
            'plan' => 'required'
        ]);
      
        try {
            $stripeCheckout = $this->request->user()
                ->newSubscription('default', $this->request->plan)
                ->checkout([
                    'cancel_url' => route('subscribe'),
                ]);
        } 
        catch (\Stripe\Exception\InvalidRequestException $ex) 
        {
            return response()->json(['error' => $ex->getMessage()], $ex->getError()->code);
        } 
        catch (Exception $ex) 
        {
            return response()->json(['error' => $ex->getMessage()], $ex->getError()->code);
        }

        $response = [];

        $response['links'] = [
            'subscribe' => [
                'href' => $stripeCheckout->url,
                'rel' => 'subscribe',
                'type' => 'GET'
            ],
        ];
        
        return $response;
    }
}
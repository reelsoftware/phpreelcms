<?php
namespace App\Helpers\PaymentProcessor;

/**
 * The Context defines the interface for payment
 */
class PaymentContext
{
    /**
     * @var PaymentStrategy Reference to one concrete PaymentStrategy that 
     * implements the payment process itself
     */
    private $paymentStrategy;

    /**
     * Replace the strategy at runtime depending on what payment method was selected
     * by the user
     */
    public function setPaymentStrategy(IPaymentStrategy $strategy)
    {
        $this->paymentStrategy = $strategy;
    }

    /**
     * Execute the payment and return true for successful payments and 
     * false for failed payments
     */
    public function execute(): bool
    {
        return $this->paymentStrategy->pay();
    }
}
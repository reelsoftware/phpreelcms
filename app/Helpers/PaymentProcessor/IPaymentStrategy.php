<?php
namespace App\Helpers\PaymentProcessor;

/**
 * IPaymentStrategy declares operations common to all payment strategies
 *
 * This is used inside PaymentContext to call the appropriate strategy
 */
interface IPaymentStrategy
{
    public function pay();
}
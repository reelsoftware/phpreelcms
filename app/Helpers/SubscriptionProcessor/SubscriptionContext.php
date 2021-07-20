<?php
namespace App\Helpers\SubscriptionProcessor;

/**
 * The Context defines the interface for subscriptions
 */
class SubscriptionContext
{
    /**
     * @var ISubscriptionStrategy Reference to one concrete SubscriptionStrategy that 
     * implements the subscription itself
     */
    private $subscriptionStrategy;

    /**
     * Replace the strategy at runtime depending on what payment processing company is used
     */
    public function setSubscriptionStrategy(ISubscriptionStrategy $strategy)
    {
        $this->subscriptionStrategy = $strategy;
    }

    /**
     * Show all the subscriptions
     */
    public function index()
    {
        return $this->subscriptionStrategy->index();
    }

    /**
     * Create subscription
     */
    public function create()
    {
        return $this->subscriptionStrategy->create();
    }

    /**
     * Store the subscription
     */
    public function store()
    {
        return $this->subscriptionStrategy->store();
    }

    /**
     * Edit the subscription
     */
    public function edit()
    {
        return $this->subscriptionStrategy->edit();
    }

    /**
     * Update the subscription
     */
    public function update()
    {
        return $this->subscriptionStrategy->update();
    }
}
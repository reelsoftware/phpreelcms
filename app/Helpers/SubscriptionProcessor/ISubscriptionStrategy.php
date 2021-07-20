<?php
namespace App\Helpers\SubscriptionProcessor;

/**
 * ISubscriptionStrategy declares operations common to all subscriptions
 *
 * This is used inside SubscriptionContext to call the appropriate strategy
 */
interface ISubscriptionStrategy
{
    public function index();
    public function create();
    public function store();
    public function edit();
    public function update();
}
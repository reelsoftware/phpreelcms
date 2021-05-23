<?php

namespace App\Http\Traits;

trait SubscriptionDetailsTrait {

    //When the subscription is going to renew
    private function currentPeriodEnd($stripeCustomer)
    {
        if($stripeCustomer->subscriptions['data'] != null && $stripeCustomer->subscriptions['data'][0]['current_period_end'] != null)
            return date("Y-m-d H:i:s", $stripeCustomer->subscriptions['data'][0]['current_period_end']);
        else
            return null;
    }

    //When the subscription was canceled
    private function canceledAt($stripeCustomer)
    {
        if($stripeCustomer->subscriptions['data'] != null && $stripeCustomer->subscriptions['data'][0]['canceled_at'] != null)
            return date("Y-m-d H:i:s", $stripeCustomer->subscriptions['data'][0]['canceled_at']);
        else
            return null;
    }

    //When is the canceled subscription going to end
    private function cancelAt($stripeCustomer)
    {
        if($stripeCustomer->subscriptions['data'] != null && $stripeCustomer->subscriptions['data'][0]['cancel_at'] != null)
            return date("Y-m-d H:i:s", $stripeCustomer->subscriptions['data'][0]['cancel_at']);
        else
            return null;
    }

    //Boolean if the subscription is canceled
    private function cancelAtPeriodEnd($stripeCustomer)
    {
        if($stripeCustomer->subscriptions['data'] != null && $stripeCustomer->subscriptions['data'][0]['cancel_at_period_end'] == true)
            return true;
        else
            return null;
    }
}
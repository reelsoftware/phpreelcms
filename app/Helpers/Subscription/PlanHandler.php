<?php
namespace App\Helpers\Subscription; 

use App\Models\Setting;

class PlanHandler
{
    /**
     * Return all the available public subscription plans
     *
     */
    public static function getPublicPlans()
    {
        $plans = Setting::where('setting', '=', 'default_subscription')
            ->join('subscription_types', 'subscription_types.name', '=', 'settings.value')
            ->join('subscription_plans', 'subscription_plans.subscription_type_id', '=', 'subscription_types.id')
            ->where('subscription_plans.public', '=', 1)
            ->get();

        return $plans;
    }

    /**
     * Return all the available (including public and private) subscription plans
     *
     */
    public static function getAllPlans()
    {
        $plans = Setting::where('setting', '=', 'default_subscription')
            ->join('subscription_types', 'subscription_types.name', '=', 'settings.value')
            ->join('subscription_plans', 'subscription_plans.subscription_type_id', '=', 'subscription_types.id')
            ->get();

        return $plans;
    }
}
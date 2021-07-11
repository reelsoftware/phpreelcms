<?php

/**
 * Render a specific pagination file
 *
 * @param string $price of the subscription plan
 * @param string $stripe_price_id id of the subscription plan from stripe
 * @param string $name of the subscription plan
 * @param string $currency of the subscription plan
 * 
 */
if (!function_exists('add_required_fields_subscription')) 
{
    function add_required_fields_subscription($price, $stripe_price_id, $name, $currency)
    {
        echo "
            <input type=\"hidden\" value=\"$price\" name=\"price\">
            <input type=\"hidden\" value=\"$stripe_price_id\" name=\"plan\">
            <input type=\"hidden\" value=\"{{$name}}\" name=\"planName\">
            <input type=\"hidden\" value=\"{{$currency}}\" name=\"currency\">
        ";
    }
}

if (!function_exists('get_price')) 
{
    function get_price($price)
    {
        return (float)$price/100;
    }
}
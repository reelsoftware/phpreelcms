<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use DB;

class CheckStripe
{
    /**
     * Check if stripe is configured
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        //If the env values are null or the table is not seeded then redirect to the install page
        if(config('app.stripe_key') == null || config('app.stripe_secret') == null || config('app.stripe_webhook_secret') == null || empty(DB::table('subscription_types')->count()))
            return redirect(route('stripeUpdate'));

        return $next($request);
    }
}

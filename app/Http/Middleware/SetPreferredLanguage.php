<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class SetPreferredLanguage
{
    /**
     * Handle an incoming request.
     * 
     * Set the language of the app to the preferred language of the user
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        //Check if user is logged in
        if($request->user() != null)
        {
            $userLanguage = $request->user()->language;

            //If not null set app language to user's preferred language
            if($userLanguage != null)
                app()->setLocale($userLanguage);
        }

        return $next($request);
    }
}

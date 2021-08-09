<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Menu;

class CheckAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if ($request->user() && $request->user()->roles != 'admin') 
        {
            return redirect('/');
        }

        return $next($request);
    }
}

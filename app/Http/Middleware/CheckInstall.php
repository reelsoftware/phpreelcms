<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use DB;

class CheckInstall
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
        try 
        {
            DB::connection()->getPdo();
        } 
        catch (\Exception $e) 
        {
            return $next($request);
        }

        try 
        {
            $tables = DB::select('SHOW TABLES');
        } 
        catch (\Exception $e) 
        {
            return $next($request);
        }

        if($tables == null)
            return $next($request);
        else
        {
            $users = DB::table('users')->count();

            if($users == 0)
                return $next($request);
            else
                return redirect(route('home'));
        }
    }
}

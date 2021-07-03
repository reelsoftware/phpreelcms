<?php
namespace App\Helpers\User; 

use Illuminate\Http\Request;
use Jackiedo\DotenvEditor\Facades\DotenvEditor;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\URL;
use Auth;

class UserHandler
{
    /**
     * Return true if user is subscribed, false if not
     *
     * @return bool
     */
    public static function checkSubscription(): bool
    {
        $user = Auth::user();

        if(Auth::check())
        {
            $defaultSubscription = 'default';
            $subscribed = $user->subscribed($defaultSubscription);

            if($subscribed == 1)
                return true;
        }

        return false;
    }

    /**
     * Return the user role (admin, user), null if not auth
     */
    public static function getUserRole()
    {
        $user = Auth::user();

        if(Auth::check())
        {
            $user = Auth::user()->first('roles');

            return $user->roles;
        }

        return null;
    }
}
<?php
namespace App\Helpers\Install; 

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Auth;

class UserHandler
{
    /**
     * Create the new admin user
     *
     * @return array
     */
    public static function createAdmin(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|confirmed|min:8',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        Auth::login($user);

        //Make admin
        $admin = User::where('email', '=', $request->email)->first();
        $admin->roles = 'admin';
        $admin->save();
    }
}
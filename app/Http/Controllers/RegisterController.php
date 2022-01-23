<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use Validator;
use App\Models\User;
use Hash;

class RegisterController extends Controller
{
    /**
     * Register api
     *
     * @return \Illuminate\Http\Response
     */
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|confirmed|min:8',
        ]);
   
        if($validator->fails())
        {
            return response()->json($validator->errors(), 500); 
        }
   
        $input = $request->all();
        $input['password'] = Hash::make($input['password']);
        $user = User::create($input);
        $success['token'] =  $user->createToken(config('app.name'))->plainTextToken;
        $success['name'] =  $user->name;
   
        return response()->json($success, 201);
    }
   
    /**
     * Login api
     *
     * @return \Illuminate\Http\Response
     */
    public function login(Request $request)
    {
        if(Auth::attempt(['email' => $request->email, 'password' => $request->password]))
        { 
            $user = Auth::user(); 
            $success['token'] =  $user->createToken(config('app.name'))->plainTextToken; 
            $success['name'] =  $user->name;
   
            return response()->json($success, 200);
        } 
        else
        { 
            return response()->json(['error' => 'Unauthorized'], 401); 
        } 
    }
}

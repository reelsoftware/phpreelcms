<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Setting;
use App\Models\Translation;
use App\Helpers\Theme\Theme;
use Auth;

class UserController extends Controller
{
    public function updateLanguage(Request $request)
    {
        $validated = $request->validate([
            'language' => 'required'
        ]);

        //Update user preferred language
        $user = Auth::user();

        //If the language is 0 then select the null option (English (Default))
        if($request->language == '0')
            $user->language = null;
        else
            $user->language = $request->language;

        $user->save();

        return redirect(route('user'));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $params = array();
        $user = Auth::user();
        $currentLanguage = config('app.language');

        //Select all the languages from the translations table
        $translations = Translation::get();

        //Remove the current language from the collection
        foreach($translations as $key => $translation) 
        {
            if(str_replace(' ', '_', $translation->language) == $currentLanguage)
            {
                $translations->forget($key);
                break;
            }
        }

        $id = $user['id'];
        $name = $user['name'];
        $email = $user['email'];
        $defaultSubscription = Setting::where('setting', '=', 'default_subscription')->first();
        
        if($defaultSubscription != null)
            $subscription = $user->subscribed($defaultSubscription['value']);
        else
            $subscription = null;

        $params['name'] = $name;
        $params['email'] = $email;
        $params['subscription'] = $subscription;
        $params['language'] = $user->language;
        $params['translations'] = $translations;
        
        return Theme::view('user.index', $params);
    }

    public function manageSubscription(Request $request)
    {
        $response = [];
        $targetUrl = $request->user()->redirectToBillingPortal()->getTargetUrl();
        
        $response['links'] = [
            'user' => [
                'href' => $targetUrl,
                'rel' => 'user',
                'type' => 'GET'
            ]
        ];

        return response()->json($response, 200);
    }
}

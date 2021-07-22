<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Setting;
use App\Models\Translation;
use App\Http\Traits\SubscriptionDetailsTrait;
use App\Helpers\Theme\Theme;
use Auth;

class UserController extends Controller
{
    use SubscriptionDetailsTrait;

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
        $defaultSubscription = Setting::where('setting', '=', 'default_subscription')->first()['value'];
        //Select all the languages from the translations table
        $translations = Translation::get();

        $id = $user['id'];
        $name = $user['name'];
        $email = $user['email'];
        $subscription = $user->subscribed($defaultSubscription);

        $params['name'] = $name;
        $params['email'] = $email;
        $params['subscription'] = $subscription;
        $params['language'] = $user->language;
        $params['translations'] = $translations;
        
        return Theme::view('user.index', $params);
    }

    public function manageSubscription(Request $request)
    {
        return $request->user()->redirectToBillingPortal(route('user'));
    }
}

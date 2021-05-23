<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Setting;
use Illuminate\Validation\Rule;
use App\Http\Traits\SubscriptionDetailsTrait;

class UserDashboardController extends Controller
{
    use SubscriptionDetailsTrait;

    public function subscriptionDetails($id)
    {
        $user = User::select('id', 'stripe_id')->find($id);
        $defaultSubscription = Setting::where('setting', '=', 'default_subscription')->first()['value'];

        //Verify if the user is subscribed
        $subscription = $user->subscribed($defaultSubscription);

        $stripeCustomer = $user->createOrGetStripeCustomer();
        //When it's going to cancel or null if it's not canceled
        $cancelAt = $this->cancelAt($stripeCustomer);

        //If cancelAt is null then this is when the subscription is going to renew
        $currentPeriodEnd = $this->currentPeriodEnd($stripeCustomer);

        return view('usersDashboard.subscriptionDetails', [
            'cancelAt' => $cancelAt,
            'currentPeriodEnd' => $currentPeriodEnd,
            'subscription' => $subscription,
        ]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::orderByDesc('id')
            ->select('id', 'name', 'email', 'created_at', 'roles', 'stripe_id')
            ->simplePaginate(10);

        $stripeCustomer = $users[0]->createOrGetStripeCustomer();

        return view('usersDashboard.index', [
            'users' => $users,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = User::find($id);
        
        return view('usersDashboard.edit', [
            'user' => $user,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => [
                'required',
                'max:255',
                'string',
                'email',
                Rule::unique('users', 'email')->ignore($id)
            ],
            'roles' => 'required|string|max:25',
        ]);

        //Update user
        $user = User::find($id);
        $user->name = $request->name;
        $user->email = $request->email;
        $user->roles = $request->roles;
        $user->save();

        return redirect()->route('usersDashboard');
    }
}

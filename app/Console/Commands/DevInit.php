<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use App\Models\Setting;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Auth\Events\Registered;

class DevInit extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'dev:init';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create phpReel admin account and seed the database (development purposes only)';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $name = $this->ask('Admin name');
        $email = $this->ask('Admin email');
        $password = $this->secret('Admin password');

        //Create new admin user
        try {
            $user = User::create([
                'name' => $name,
                'email' => $email,
                'password' => Hash::make($password),
            ]);
        } catch(\Illuminate\Database\QueryException $ex) {
            $errorCode = $ex->errorInfo[0];

            if($errorCode == '23000')
                $this->error('Email must be unique, please try a different email (it doesn\'t have to be a real email).');
            else
                $this->error('Something went wrong, please try again.');

            return;
        }

        Auth::login($user);

        event(new Registered($user));

        //Make admin
        $admin = User::where('email', '=', $email)->first();
        $admin->roles = 'admin';
        $admin->save();

        //Add settings
        $settings = [
            ['setting' => 'default_subscription', 'value' => 'default']
        ];

        Setting::insert($settings); 

        $this->info("Account $email was created successfully.");
    }
}

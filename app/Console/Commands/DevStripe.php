<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Jackiedo\DotenvEditor\Facades\DotenvEditor;
use App\Models\SubscriptionType;

class DevStripe extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'dev:stripe';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Initialize Stripe for phpReel to be able to work with subscriptions (development purposes only)';

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
        if ($this->confirm('Do you wish to setup Stripe now? This can be done later from the dashboard.', false)) {
            $env = [];  

            $stripeKey = DotenvEditor::getValue('STRIPE_KEY');
            $stripeSecret = DotenvEditor::getValue('STRIPE_SECRET');
            $stripeWebhookSecret = DotenvEditor::getValue('STRIPE_WEBHOOK_SECRET');

            if($stripeKey == '')
            {
                $this->info("Stripe public key is missing from the .env file. You can get this value from your Stripe account.");
                $env['STRIPE_KEY'] = $this->ask('Stripe public key');
            }

            if($stripeSecret == '')
            {
                $this->info("Stripe secret key is missing from the .env file. You can get this value from your Stripe account.");
                $env['STRIPE_SECRET'] = $this->ask('Stripe secret key');
                $stripeSecret = $env['STRIPE_SECRET'];
            }

            if($stripeWebhookSecret == '')
            {
                $this->info("Stripe webhook secret key is missing from the .env file. You can get this value from your Stripe account.");
                $env['STRIPE_WEBHOOK_SECRET'] = $this->ask('Stripe webhook secret key');
            }

            if(!empty($env))
            {
                DotenvEditor::setKeys($env);
                DotenvEditor::save();
            }

            //Create a mock Stripe product and save it to the database
            $stripe = new \Stripe\StripeClient($stripeSecret);
            $product = $stripe->products->create([
                'name' => 'default',
            ]);

            //Add subscription to the database
            $subscriptionType = new SubscriptionType();
            $subscriptionType->name = 'default';
            $subscriptionType->product_id = $product['id'];
            $subscriptionType->public = '1';
            $subscriptionType->save();

            $this->info("Stripe was configured successfully.");
        }
    }
}

<?php

namespace App\Http\Controllers;

use App\Helpers\Install\MigrationExecutor; 
use Illuminate\Http\Request;
use App\Models\Setting;
use Jackiedo\DotenvEditor\Facades\DotenvEditor;
use App\Models\SubscriptionType;

class SettingsController extends Controller
{
    public function storage()
    {
        $storageDisk = DotenvEditor::getValue('STORAGE_DISK');
        $awsAccessKeyId = DotenvEditor::getValue('AWS_ACCESS_KEY_ID');
        $awsSecretAccessKey = DotenvEditor::getValue('AWS_SECRET_ACCESS_KEY');
        $awsDefaultRegion = DotenvEditor::getValue('AWS_DEFAULT_REGION');
        $awsBucket = DotenvEditor::getValue('AWS_BUCKET');
        $chunkSize = DotenvEditor::getValue('CHUNK_SIZE');

        return view('settings.storage', [
            'storageDisk' => $storageDisk,
            'awsAccessKeyId' => $awsAccessKeyId,
            'awsSecretAccessKey' => $awsSecretAccessKey,
            'awsDefaultRegion' => $awsDefaultRegion,
            'awsBucket' => $awsBucket,
            'chunkSize' => $chunkSize
        ]);
    }

    public function storageStore(Request $request)
    {
        $validationArray = [
            'storageDisk' => 'required',
            'chunkSize' => 'required|numeric',
        ];

        if($request->storageDisk == 's3')
        {
            //Validation only applies if there are no values inside the env file
            if(config('app.aws_access_key_id') == null)
                $validationArray['awsAccessKeyId'] = 'required';

            if(config('app.aws_secret_access_key') == null)
                $validationArray['awsSecretAccessKey'] = 'required';

            if(config('app.aws_default_region') == null)
                $validationArray['awsDefaultRegion'] = 'required';

            if(config('app.aws_bucket') == null)
                $validationArray['awsBucket'] = 'required';
        }

        $validated = $request->validate($validationArray);
        
        //Store data for s3
        if($request->storageDisk == 's3')
        {
            //Store or update the values in the env file
            $s3 = [];

            $s3['STORAGE_DISK'] = $request->storageDisk;
            $s3['CHUNK_SIZE'] = $request->chunkSize;

            if($request->awsAccessKeyId != null)
                $s3['AWS_ACCESS_KEY_ID'] = $request->awsAccessKeyId;

            if($request->awsSecretAccessKey != null)
                $s3['AWS_SECRET_ACCESS_KEY'] = $request->awsSecretAccessKey;

            if($request->awsDefaultRegion != null)
                $s3['AWS_DEFAULT_REGION'] = $request->awsDefaultRegion;

            if($request->awsBucket != null)
                $s3['AWS_BUCKET'] = $request->awsBucket;

            DotenvEditor::setKeys($s3);
        }
        else if($request->storageDisk == 'local')
        {
            $file = DotenvEditor::setKeys([
                'STORAGE_DISK' => $request->storageDisk,
                'CHUNK_SIZE' => $request->chunkSize,
            ]);
        }

        DotenvEditor::save();  

        return redirect(route('settingsStorage'));
    }

    public function version()
    {
        $appVersion = DotenvEditor::getValue('APP_VERSION');

        return view('settings.version', [
            'appVersion' => $appVersion,
        ]);
    }

    public function versionUpdate()
    {
        //Update for every new added version
        $lastVersion = '0.2.0-Beta';

        //Get current app version
        $appVersion = DotenvEditor::getValue('APP_VERSION');

        //Compare new version to last version
        if($lastVersion != $appVersion)
        {
            //Update to last version
            DotenvEditor::setKeys([
                'APP_VERSION' => $lastVersion,
            ]);

            DotenvEditor::save();    
        } 

        //Migrate the table to the database
        MigrationExecutor::migrateDatabase();

        return redirect(route('settingsVersion'));
    }

    //App settings
    public function app()
    {
        $appName = DotenvEditor::getValue('APP_NAME');

        return view('settings.app', [
            'appName' => $appName,
        ]);
    }

    public function appUpdate(Request $request)
    {
        $validationArray = [
            'appName' => 'required',
        ];

        $validated = $request->validate($validationArray);
        
        $file = DotenvEditor::setKeys([
            'APP_NAME' => $request->appName,
        ]);

        DotenvEditor::save();  

        return redirect(route('settingsApp'));
    }

    //Email settings
    public function email()
    {
        $mailer = DotenvEditor::getValue('MAIL_MAILER');
        $host = DotenvEditor::getValue('MAIL_HOST');
        $port = DotenvEditor::getValue('MAIL_PORT');
        $username = DotenvEditor::getValue('MAIL_USERNAME');
        $password = DotenvEditor::getValue('MAIL_PASSWORD');
        $fromAddress = DotenvEditor::getValue('MAIL_FROM_ADDRESS');

        return view('settings.mail', [
            'mailer' => $mailer,
            'host' => $host,
            'port' => $port,
            'username' => $username,
            'password' => $password,
            'fromAddress' => $fromAddress,
        ]);

    }

    public function emailUpdate(Request $request)
    {
        $validationArray = [
            'mailer' => 'required',
            'host' => 'required',
            'port' => 'required',
            'username' => 'required',
            'password' => 'required',
            'fromAddress' => 'required',
        ];

        $validated = $request->validate($validationArray);
        
        $file = DotenvEditor::setKeys([
            'MAIL_MAILER' => $request->mailer,
            'MAIL_HOST' => $request->host,
            'MAIL_PORT' => $request->port,
            'MAIL_USERNAME' => $request->username,
            'MAIL_PASSWORD' => $request->password,
            'MAIL_FROM_ADDRESS' => $request->fromAddress,
        ]);

        DotenvEditor::save();  

        return redirect(route('settingsEmail'));
    }

    public function stripe()
    {
        return view('settings.stripe');
    }

    public function stripeUpdate(Request $request)
    {
        //Validation only applies if there are no values inside the env file
        $validationArray = [];

        if(config('app.stripe_key') == null)
            $validationArray['stripeKey'] = 'required';

        if(config('app.stripe_secret') == null)
            $validationArray['stripeSecret'] = 'required';

        if(config('app.stripe_webhook_secret') == null)
            $validationArray['stripeWebhookSecret'] = 'required';

        if(count($validationArray))    
            $request->validate($validationArray);

        //Store or update the values in the env file
        $stripe = [];

        if($request->stripeKey != null)
            $stripe['STRIPE_KEY'] = $request->stripeKey;

        if($request->stripeSecret != null)
            $stripe['STRIPE_SECRET'] = $request->stripeSecret;

        if($request->stripeWebhookSecret != null)
            $stripe['STRIPE_WEBHOOK_SECRET'] = $request->stripeWebhookSecret;

        DotenvEditor::setKeys($stripe);
        DotenvEditor::save();

        //Seed the database if it's empty
        if(empty(SubscriptionType::count()))
        {
            //Create subscription
            //Add data to Stripe
            $stripe = new \Stripe\StripeClient($stripe['STRIPE_SECRET']);
            $product = $stripe->products->create([
                'name' => 'default',
            ]);

            //Add subscription to the database
            $subscriptionType = new SubscriptionType();
            $subscriptionType->name = 'default';
            $subscriptionType->product_id = $product['id'];
            $subscriptionType->public = '1';
            $subscriptionType->save();
        }

        if(empty(Setting::count()))
        {
            //Add settings
            $settings = [
                ['setting' => 'default_subscription', 'value' => 'default']
            ];

            Setting::insert($settings);
        }

        return redirect(route('subscriptionPlanCreate'));
    }
}

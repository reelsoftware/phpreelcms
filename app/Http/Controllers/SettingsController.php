<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Setting;
use Jackiedo\DotenvEditor\Facades\DotenvEditor;
use App\Http\Traits\MigrateDatabaseTrait;

class SettingsController extends Controller
{
    use MigrateDatabaseTrait;

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
            $validationArray['awsAccessKeyId'] = 'required';
            $validationArray['awsSecretAccessKey'] = 'required';
            $validationArray['awsDefaultRegion'] = 'required';
            $validationArray['awsBucket'] = 'required';
        }

        $validated = $request->validate($validationArray);
        
        //Store data for s3
        if($request->storageDisk == 's3')
        {
            $file = DotenvEditor::setKeys([
                'STORAGE_DISK' => $request->storageDisk,
                'CHUNK_SIZE' => $request->chunkSize,
                'AWS_ACCESS_KEY_ID' => $request->awsAccessKeyId,
                'AWS_SECRET_ACCESS_KEY' => $request->awsSecretAccessKey,
                'AWS_DEFAULT_REGION' => $request->awsDefaultRegion,
                'AWS_BUCKET' => $request->awsBucket,
            ]);
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
        $lastVersion = '1.0';

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
        $this->migrateDatabase();

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
}

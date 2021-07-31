<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Helpers\Install\MigrationExecutor;
use App\Helpers\Install\UserHandler;
use App\Helpers\Install\EnvHandler;

class InstallController extends Controller
{
    /**
     * Handler for the env file 
     * @var EnvHandler
     */
    private $envHandler;

    public function __construct()
    {
        $this->envHandler = new EnvHandler();
        $this->envHandler->setEnvFields();
        $this->envHandler->setValidatedFields();
    }

    /**
     * Renders the view for the env fields
     *
     * @return view
     */
    public function config()
    {
        $envFields = $this->envHandler->getEnvFields();
        
        return view('install.config', [
            'envFields' => $envFields,
        ]);
    }

    /**
     * Stores the inputs from the config view
     *
     * @return redirect
     */
    public function storeConfig(Request $request)
    {    
        //Validate the input env fields 
        $request->validate($this->envHandler->getValidatedFields());

        //Save the env fields from the request
        $this->envHandler->storeEnvFields($request);

        return redirect(route('installSeed'));
    }

    /**
     * Renders the view for the database seeding and account creation
     *
     * @return view
     */
    public function seed()
    {
        return view('install.seed');
    }

    /**
     * Migration, seeding and admin user creation
     *
     * @return redirect
     */
    public function storeSeed(Request $request)
    {
        //Migrate the database
        MigrationExecutor::migrateDatabase();
        
        //Create the admin user
        UserHandler::createAdmin($request);

        return redirect(route('home'));
    }

    /**
     * Renders the view for requirements
     *
     * @return view
     */
    public function requirements()
    {
        return view('install.requirements');
    }

    /**
     * Renders the view for the first install page
     *
     * @return view
     */
    public function index()
    {
        return view('install.index');
    }
}

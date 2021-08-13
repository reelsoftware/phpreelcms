<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Artisan;
use App\Helpers\Module\ModuleHandler;

class CreateModule extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'module:create {moduleInternalName}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Creates a new module with basic scaffolding';

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
     * @return
     */
    public function handle()
    {
        $moduleInternalName = $this->argument('moduleInternalName');

        //Check if the module name is already taken
        if(ModuleHandler::findModule($moduleInternalName))
        {
            $this->error('Name has already been taken, please try a different name');
            return;
        }

        //Call laravel-modules artisan command to create the actual module
        Artisan::call("module:make $moduleInternalName");

        //Get information about the newly created theme
        $moduleName = $this->ask('Module name');
        $description = $this->ask('Description');
        $author = $this->ask('Author');
        $moduleUrl = $this->ask('Module URL');
        $version = $this->ask('Version');
        $license = $this->ask('License');
        $licenseUrl = $this->ask('License URL');

        ModuleHandler::generateConfig($moduleInternalName, $moduleName, $description, $author, $moduleUrl, $version, $license, $licenseUrl);
        ModuleHandler::generateDefaultCover($moduleInternalName);

        $this->info("Module $moduleInternalName was created successfully! You can find it here: Modules/$moduleInternalName");
    }
}

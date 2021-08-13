<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Helpers\Theme\Theme;

class CreateTheme extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'theme:make {themeDirectoryName}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Creates a new theme with basic scaffolding';

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
        $themeDirectoryName = $this->argument('themeDirectoryName');

        //Check if the theme name is already taken
        if(Theme::findTheme($themeDirectoryName))
        {
            $this->error('Name has already been taken, please try a different name');
            return;
        }

        //Get information about the newly created theme
        $themeName = $this->ask('Theme name');
        $description = $this->ask('Description');
        $author = $this->ask('Author');
        $themeUrl = $this->ask('Theme URL');
        $version = $this->ask('Version');
        $license = $this->ask('License');
        $licenseUrl = $this->ask('License URL');

        Theme::generateTheme($themeDirectoryName);
        Theme::generateConfig($themeDirectoryName, $themeName, $description, $author, $themeUrl, $version, $license, $licenseUrl);
        Theme::generateDefaultCover($themeDirectoryName);

        $this->info("Theme $themeDirectoryName was created successfully! You can find it here: resources/themes/$themeDirectoryName");
    }
}

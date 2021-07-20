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
    protected $signature = 'theme:make {name}';

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
        $name = $this->argument('name');

        //Check if the theme name is already taken
        if(Theme::findTheme($name))
        {
            $this->error('Name has already been taken, please try a different name');
            return;
        }



    }
}

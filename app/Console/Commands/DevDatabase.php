<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Jackiedo\DotenvEditor\Facades\DotenvEditor;

class DevDatabase extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'dev:database';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Set the .env variables for the database (development purposes only)';

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
        $env = [];

        $env['DB_CONNECTION'] = $this->ask('Database type', 'mysql');
        $env['DB_HOST'] = $this->ask('Database host', 'localhost');
        $env['DB_PORT'] = $this->ask('Database port', '3306');
        $env['DB_DATABASE'] = $this->ask('Database name');
        $env['DB_USERNAME'] = $this->ask('Database username', 'root');
        $env['DB_PASSWORD'] = $this->ask('Database password', '');

        DotenvEditor::setKeys($env);
        DotenvEditor::save();

        $this->info("Database was configured successfully.");
    }
}

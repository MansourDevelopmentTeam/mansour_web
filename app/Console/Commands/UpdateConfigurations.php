<?php

namespace App\Console\Commands;

use Database\Seeders\ConfigurationSeeder;
use Illuminate\Console\Command;

class UpdateConfigurations extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'seed:config';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Seed configurations table & update variables parameters';

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
        (new ConfigurationSeeder)->run();
        $this->info('Configurations Updated!');
    }
}

<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use TeamTNT\TNTSearch\TNTSearch;

class TntIndexProducts extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'tnt:index';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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
     * @return mixed
     */
    public function handle()
    {
        $tnt = new TNTSearch;
        $tnt->loadConfig(config('tnt'));

        $indexer = $tnt->createIndex('product.index');
        $indexer->query('SELECT id, name, name_ar FROM products;');
        // $indexer->setStopWords(["-"]);
        //$indexer->setLanguage('german');
        $indexer->run();
    }
}

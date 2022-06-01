<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class CreateParentForVariantsWithoutParent extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'variants:fix';

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
     * @return int
     */
    public function handle()
    {
         // TODO: Check if product already have a parent
         
         DB::table('products')->whereNull('parent_id')->orderBy('id')->chunk(100, function ($variants) {
             foreach ($variants as $variant) {
                 $parent = clone $variant;
                 unset($parent->id);
                 $parent->sku = 'MAIN_' . $variant->sku;
                 $parent = (array) $parent;
                 $parentID = DB::table('products')->insertGetId($parent);
                 DB::table('products')->where('id', $variant->id)->update(['parent_id' => $parentID]);
             }
         });
    }
}

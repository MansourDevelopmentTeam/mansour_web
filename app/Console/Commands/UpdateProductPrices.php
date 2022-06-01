<?php

namespace App\Console\Commands;

use App\Models\Products\Product;
use Illuminate\Console\Command;

class UpdateProductPrices extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'products:updatePrices';

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
        $products = Product::whereDoesntHave("prices")->get();

        foreach ($products as $key => $product) {
            
            $price = $product->createPrice();

            echo "{$price->id}: {$key} of {$products->count()}\n";
        }
    }
}

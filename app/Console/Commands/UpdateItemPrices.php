<?php

namespace App\Console\Commands;

use App\Models\Orders\OrderProduct;
use Illuminate\Console\Command;

class UpdateItemPrices extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'orders:updateItems';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Updates item prices with the current prices';

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
        $order_items = OrderProduct::with('product')->whereNull("price_id")->get();
        $count = count($order_items);

        foreach ($order_items as $key => $item) {
            $product = $item->product;
            $item->update(["price_id" => $product->getCurrentPriceId()]);
            echo "item " . $key . " of " . $count . "updated\n";
        }
    }
}

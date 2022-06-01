<?php

namespace App\Console\Commands;

use App\Models\Orders\Order;
use App\Models\Products\Product;
use Illuminate\Console\Command;

class UpdateOrdersGrandTotal extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'orders:updateGrandTotal';

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

        $orders = Order::with('items', 'invoice')->get();
        foreach ($orders as $order) {
            $invoice = $order->invoice;
            $itemsPrices = $order->items->reduce(function ($carry, $item) {
                if (is_null($item->discount_price)) {
                    return $carry + $item->price;
                } else {
                    return $carry + $item->discount_price;
                }
            }, 0);
            $invoice->update(['grand_total'=>$itemsPrices +$order->invoice->delivery_fees]);
            print "updated Order ID #{$order->id} \n";
        }

    }
}

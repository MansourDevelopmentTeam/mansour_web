<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\Facebook\ConversionAPI AS FacebookConversionAPI;
use App\Models\Orders\Order;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class ConversionApi extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cnversionapi:send {order}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send an event request using conversion Api';

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
    public function handle(FacebookConversionAPI $conversionApi)
    {
        try {
            $order = Order::findOrFail($this->argument('order'));
        } catch (ModelNotFoundException $ex) {
            $this->warn('Order not found');
            return Command::SUCCESS;
        }
        $conversionApi->send($order);
        $this->info('Conversion API sent');
        return Command::SUCCESS;
    }
}

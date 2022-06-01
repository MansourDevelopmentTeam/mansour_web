<?php

namespace App\Console\Commands;

use App\Models\Orders\Order;
use App\Models\Orders\OrderSchedule;
use App\Models\Orders\OrderState;
use App\Models\Payment\PaymentMethods;
use App\Models\Services\PushService;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class ScheduledOrders extends Command
{
    private $pushService;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'orders:scheduled';

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
    public function __construct(PushService $pushService)
    {
        parent::__construct();
        $this->pushService = $pushService;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $orders = Order::whereNotNull("scheduled_at")->where("scheduled_at", "<", Carbon::now())->get();

        foreach ($orders as $order) {
            $order->scheduled_at = null;
            $order->save();

            $this->pushService->notifyAdmins("New Order", "You have received a new order {$order->id}");
            $this->pushService->notify($order->customer, __('notifications.placedOrderTitle'), __('notifications.placedOrderBody'));
        }
    }
}

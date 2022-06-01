<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use App\Models\Orders\Order;
use Illuminate\Console\Command;
use App\Models\Orders\OrderState;
use Illuminate\Support\Facades\DB;
use App\Models\Orders\OrderSchedule;
use App\Models\Services\PushService;
use App\Models\Payment\PaymentMethod;
use App\Models\Payment\PaymentMethods;

class RecurringOrders extends Command
{
    private $pushService;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'orders:recurring';

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
        $week_day = date('N', strtotime('Monday'));
        $month_day = date("d");

        // $schedules = DB::table("order_schedule")->join("schedule_days", "order_schedule.id", "=", "schedule_days.schedule_id")
        //     ->where("order_schedule.interval", OrderSchedule::DAILY)
        //     ->orWhere(function ($q) use ($week_day) {
        //         $q->where("order_schedule.interval", OrderSchedule::WEEKLY)->where("day", $week_day);
        //     })
        //     ->orWhere(function ($q) use ($month_day) {
        //         $q->where("order_schedule.interval", OrderSchedule::MONTHLY)->where("day", $month_day);
        //     })
        //     ->get()->toArray();

        $schedules = OrderSchedule::with("days")->where("interval", OrderSchedule::DAILY)->get()->toArray();

        echo count($schedules) . "\n";
        foreach ($schedules as $schedule) {
            echo $schedule["order_id"] . "\n";
            $order = Order::with("items", "invoice")->find($schedule["order_id"]);

            // recreate orders
            $new_order = $order->replicate();
            $new_order->created_at = Carbon::parse(date("Y-m-d") . " " . $schedule["time"]);
            $new_order->state_id = OrderState::CREATED;
            $new_order->deliverer_id = null;
            $new_order->paid_amount = 0;
            $new_order->payment_method = PaymentMethod::METHOD_CASH;
            $new_order->parent_id = $order->id;
            $new_order->rate = null;
            $new_order->customer_rate = null;
            $new_order->save();

            // repopulate items
            foreach ($order->items as $item) {
                $new_order->items()->create(["product_id" => $item["product_id"], "amount" => $item["amount"], "price_id" => $item["price_id"]]);
            }

            $total = $new_order->getTotal();

            // generate invoice
            $invoice = $new_order->invoice()->create(["total_amount" => $total]);

            // send notifications
            $this->pushService->notify($new_order->customer, __('notifications.placedOrderTitle'), __('notifications.placedOrderBody'));
        }

    }
}

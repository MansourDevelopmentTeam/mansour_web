<?php

namespace App\Console\Commands;

use App\Models\Orders\Order;
use Illuminate\Console\Command;
use Jenssegers\Agent\Agent;

class ConvertUserAgent extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'convert:agent';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'convert user agent to (web, ios, android, postman)';

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
        $agent = new Agent();
        $orders = Order::orderBy('id', 'desc')->get();
        foreach ($orders as $order) {
            $agent->setUserAgent($order->user_agent);
            if($order->user_agent) {
                if($agent->isAndroidOS() || strpos($order->user_agent, 'okhttp') !== false) {
                    $type = 'android';
                } else if ($agent->is('iPhone')) {
                    $type = 'ios';
                } else if ($agent->isDesktop()) {
                    $type = 'web';
                } else {
                    $type = $order->user_agent;
                }
                $order->update([
                    'user_agent' => $type
                ]);
                $this->info("order -> {$order->id}  updated with ($type)");
            }
        }
    }
}

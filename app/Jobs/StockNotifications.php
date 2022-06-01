<?php

namespace App\Jobs;

use App\Models\Users\User;
use Illuminate\Bus\Queueable;
use App\Mail\StockNotifications AS StockNotificationMail;
use App\Models\Products\Product;
use App\Models\Services\PushService;
use Illuminate\Support\Facades\Mail;
use Illuminate\Queue\SerializesModels;
use App\Notifications\ProductAvailable;
use Illuminate\Queue\InteractsWithQueue;
use App\Models\Products\StockNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Notification;

class StockNotifications implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $product;
    public function __construct(Product $product)
    {
        $this->product = $product;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $stock_notifiers = StockNotification::with('user')->where('product_id', $this->product->id)->get();

        $users = $stock_notifiers->pluck('user')->reject(function($item) {
            return $item == null;
        });

        if($users->isNotEmpty()){
            Notification::send($users, new ProductAvailable($this->product));
        }

        foreach ($stock_notifiers as $notifier) {
            if($notifier->email != null){
                Mail::to($notifier->email)->send(new StockNotificationMail($this->product));
            }
        }
        $this->product->stock_notifiers()->detach();
    }
}

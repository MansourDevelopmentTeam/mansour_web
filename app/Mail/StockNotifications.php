<?php

namespace App\Mail;

use App\Models\Products\Product;
use App\Models\Services\PushService;
use App\Models\Users\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class StockNotifications extends Mailable
{
    // private $user;
    private $product;
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Product $product)
    {
        $this->product = $product;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject("{$this->product->name} " . trans('email.isAvailable') )->view('emails.stock_notifier', ["product" => $this->product]);
    }
}

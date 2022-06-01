<?php

namespace App\Jobs;

use App\Facade\Payment;
use App\Models\Users\User;
use Illuminate\Bus\Queueable;
use App\Models\Orders\Transaction;
use Illuminate\Support\Facades\Log;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Facades\App\Models\Services\OrdersService;
use Illuminate\Contracts\Queue\ShouldBeUnique;

class CheckPayTapsPayment implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $transaction;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Transaction $transaction)
    {
        $this->transaction = $transaction;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        if (!$this->transaction->transaction_status || ($this->transaction->transaction_status && !$this->transaction->order)) {
            Log::info("PayTaps failed: \n". json_encode(['transaction' => $this->transaction]));
            
            $paymentVerify = Payment::store($this->transaction->payment_method_id)->verify($this->transaction);

            if ($paymentVerify) {

                $user = User::findOrFail($this->transaction->customer_id);
                $order = OrdersService::createOrder($this->transaction->order_details, $user);

                Log::info("Success Transaction: \n". json_encode($this->transaction));
            } else {
                Log::info("Failed Transaction: \n". json_encode($this->transaction));
            }
        }

    }
}

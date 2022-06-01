<?php

namespace App\Jobs;

use App\Facade\Payment;
use App\Models\Users\User;
use App\Services\Orange\SMSService;
use Illuminate\Bus\Queueable;
use App\Models\Orders\Transaction;
use Illuminate\Support\Facades\Log;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Facades\App\Models\Services\OrdersService;
use Illuminate\Contracts\Queue\ShouldBeUnique;

class SendSMSViaOrange implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $mobileNumber;

    private $message;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(string $mobileNumber, string $message)
    {
        $this->mobileNumber = $mobileNumber;
        $this->message = $message;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(SMSService $service)
    {
        try {
            $service->sendSMS($this->mobileNumber, $this->message);
            Log::info('Mobile number is ' . $this->mobileNumber . ' message is : ' . $this->message);
        } catch (\Exception $exception) {
            Log::error("Error in FILE: " . __FILE__ . "\nLine: " . __LINE__ . "\nException: " .$exception->getMessage());
        }
    }
}

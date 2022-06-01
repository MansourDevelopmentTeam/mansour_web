<?php

namespace App\Mail;

use App\Models\Products\Product;
use App\Models\Services\PushService;
use App\Models\Users\Affiliates\AffiliateRequest;
use App\Models\Users\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class AffiliateRequestUpdate extends Mailable
{
    private $affiliateRequest;
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(AffiliateRequest $affiliateRequest)
    {
        $this->affiliateRequest = $affiliateRequest;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject(trans('email.affiliateJoinRequest') )->view('emails.affiliate_request_update', ["affiliateRequest" => $this->affiliateRequest]);
    }
}

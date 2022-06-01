<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class ResetUserPasswordV2 extends Mailable
{
    private $user;
    private $token;

    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($user, $token)
    {
        //
        $this->user = $user;
        $this->token = $token;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        // WEB_BRAND_COLOR
        $mainColor = config('constants.primary_color') ?? "#ff3b5c";
        return $this->subject("Reset Password")->view('emails.user_reset_password_v2', [
            "user" => $this->user,
            "token" => $this->token,
            "mainColor" => $mainColor
        ]);
    }
}

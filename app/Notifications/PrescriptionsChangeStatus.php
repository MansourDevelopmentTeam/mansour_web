<?php

namespace App\Notifications;

use App\Models\Medical\Prescription;
use App\Notifications\Channels\CustomDbChannel;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class PrescriptionsChangeStatus extends Notification
{
    use Queueable;

    private $prescription;

    /**
     * Create a new notification instance.
     *
     * @param $prescription
     * @return void
     */
    public function __construct(Prescription $prescription)
    {
        $this->prescription = $prescription;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail', CustomDbChannel::class,];
    }

    public function toDatabase($notifiable)
    {
        return [
            "user_id" => $notifiable->id,
            "type" => 5,
            "details" => $this->prescription,
            "item_id" => $this->prescription->id,
            "read" => 0,
            "title" => 'Prescription status is changed',
            "title_ar" => 'Prescription status is changed',
            "body" => "Your prescription status no. {$this->prescription->id} is changed to {$this->prescription->status_word}",
            "body_en" => "Your prescription status no. {$this->prescription->id} is changed to {$this->prescription->status_word}"
        ];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)->view(
            'emails.prescription_change_status', ['prescription' => $this->prescription]
        );
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}

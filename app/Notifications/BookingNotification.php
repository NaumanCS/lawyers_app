<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class BookingNotification extends Notification
{
    use Queueable;
    protected $orderId;
    /**
     * Create a new notification instance.
     */
    public function __construct($orderId)
    {
        $this->orderId = $orderId;
    }


    public function toDatabase($notifiable)
    {
        return [
            'message' => 'You have a new booking for your legal services.',
            'order_id' => $this->orderId->id,
            'type' =>'booking',
        ];
    }

    public function via($notifiable)
    {
        return ['database']; // Specify 'database' as the delivery channel
    }
}

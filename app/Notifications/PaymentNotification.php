<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class PaymentNotification extends Notification
{
    use Queueable;
    protected $transactionId;
    protected $orderId;

    /**
     * Create a new notification instance.
     */
    public function __construct($transactionId,$orderId)
    {
        $this->transactionId = $transactionId;
        $this->orderId = $orderId;

    }


    public function toDatabase($notifiable)
    {
        return [
            'message'   => 'You have received a new payment.',
            'transactionId' => $this->transactionId->id,
            'type'      => 'payment',
            'detail' => 'Your payment of order id ' . $this->orderId . ' is completed'

        ];
    }
    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['database']; // Specify 'database' as the delivery channel
    }

    
  
}

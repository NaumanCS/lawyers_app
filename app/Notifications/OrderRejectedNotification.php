<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\URL;

class OrderRejectedNotification extends Notification
{
    use Queueable;
    protected $order;
    protected $user;
   
    /**
     * Create a new notification instance.
     */
    public function __construct($order,$user)
    {
        $this->order = $order;
        $this->user = $user;

    

    }
    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail','database'];
    }



    public function toMail($notifiable)
    {
    
        $fromAddress = config('mail.from.address');
        $fromName = config('mail.from.name');
        $order = $this->order;
        $url = config('app.url');
    
        return (new MailMessage)
        ->from($fromAddress, $fromName)
        ->subject('Order Rejected')
        ->view('front-layouts.pages.emails.notification-mail', [
            'fromName' => $fromName,
            'userName' => $this->user,
            'orderMessage' => $order->rejection_reason,
            'url' => $url,
            'messageOne' => 'Your order has been rejected for the following reason:',
            'messageTwo' => 'Please resubmit your request using your payment slip'
        ]);
    }

    public function toDatabase($notifiable)
    {
        return [
            'message'   => 'Order Rejected.',
            'orderId' => $this->order->id,
            'type'      => 'rejection',
            'detail' => "Please resubmit your request using your payment slip, " .$this->order->rejection_reason

        ];
    }
    /**
     * Get the mail representation of the notification.
     */
   
    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    // public function toArray(object $notifiable): array
    // {
    //     return [
    //         //
    //     ];
    // }

   
}

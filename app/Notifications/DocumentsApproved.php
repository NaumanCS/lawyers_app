<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class DocumentsApproved extends Notification
{
    use Queueable;
    public $lawyer;
    /**
     * Create a new notification instance.
     */
    public function __construct($lawyer)
    {
        $this->lawyer = $lawyer;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['database','mail'];
    }

    public function toMail($notifiable)
    {
    
        $fromAddress = config('mail.from.address');
        $fromName = config('mail.from.name');
        $url = config('app.url');
    
        return (new MailMessage)
        ->from($fromAddress, $fromName)
        ->subject('Document Approved')
        ->view('front-layouts.pages.emails.notification-mail', [
            'fromName' => $fromName,
            'userName' => $this->lawyer,
            'url' => $url,
            'messageOne' => 'Your document are verified:',
            'messageTwo' => 'Your profile is ready to show to customers'
        ]);
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'message'   => 'Document approved',
            'type'      => 'approved',
            'user_id' => $this->lawyer['id'],
            'name' => $this->lawyer['name'],
            'email' => $this->lawyer['email']
        ];
    }
}

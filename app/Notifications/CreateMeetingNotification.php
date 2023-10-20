<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class CreateMeetingNotification extends Notification
{
    use Queueable;
    protected $newMeeting;
    /**
     * Create a new notification instance.
     */
    public function __construct($newMeeting)
    {
        $this->newMeeting = $newMeeting;
    }


    public function toDatabase($notifiable)
    {
        return [
            'message' => 'You have a new meeting Schedule.',
            'meeting_id' => $this->newMeeting->id,
            'type' => 'meeting'
        ];
    }

    public function via($notifiable)
    {
        return ['database']; // Specify 'database' as the delivery channel
    }
}

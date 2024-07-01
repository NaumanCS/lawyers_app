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
    protected $getDate;
    protected $customerName;


    /**
     * Create a new notification instance.
     */
    public function __construct($newMeeting,$customerName)
    {
        $this->newMeeting = $newMeeting;
        $this->customerName = $customerName;


    }


    public function toDatabase($notifiable)
    {
        return [
            'message' => 'You have a new meeting Schedule.',
            'meeting_id' => $this->newMeeting->id,
            'type' => 'meeting',
            'detail' => 'You have a meeting schedule with ' . $this->customerName->name . ' at this date ' . $this->newMeeting->date
        ];
    }

    public function via($notifiable)
    {
        return ['database']; // Specify 'database' as the delivery channel
    }
}

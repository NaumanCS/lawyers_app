<?php

namespace App\Http\Controllers\Notification;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function markAsRead($notificationId)
    {
        // Find the notification by ID
        $auth = auth()->user();
        $notification = $auth->notifications()->find($notificationId);

        // Mark the notification as read
        if ($notification) {
            $notification->markAsRead();
        }


        $notificationData = $notification->data;
        if ($auth->role == "lawyer") {
            if ($notificationData['type'] == 'meeting') {
                return redirect()->route('lawyer_meeting_list');
            } else {
                return redirect()->route('lawyer.all.orders');
            }
        }else{
            return redirect()->route('order.index');
        }
    }
}

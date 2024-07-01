<?php

namespace App\Http\Controllers\Api\Notification;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    public function all_notifications()
    {
        $notifications = Auth::user()->notifications()->paginate(10);

        return response()->json(['message' => 'All notifications','notifications' => $notifications], 200);
    }

    public function markAsRead($notificationId)
    {
        // Find the notification by ID
        $auth = auth()->user();
        $notification = $auth->notifications()->find($notificationId);

        // Mark the notification as read
        if ($notification) {
            $notification->markAsRead();
        return response()->json(['message' => 'Notification marked as read.'], 200);

        }else{
            return response()->json(['error' => 'Notification not found.'], 500);

        }

        
    }
}

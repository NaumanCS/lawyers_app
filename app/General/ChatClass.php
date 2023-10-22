<?php

namespace App\General;

use App\Models\ChMessage;

class ChatClass
{
    public static function getLatestMessage($chatId)
    {
        $latest = ChMessage::where("chat_id", $chatId)->orderBy("created_at", 'desc')->first();
        if ($latest) {
            return $latest->body;
        } else {
            return "Start Chat now";
        }
    }

    public static function getUnreadCount($chatId)
    {
        $count = ChMessage::where("chat_id", $chatId)->where("seen", 0)->count();
        if ($count) {
            return $count;
        } else {
            return null;
        }
    }

    public static function getLatestMessageTime($chatId)
    {
        $latest = ChMessage::where("chat_id", $chatId)->orderBy("created_at", 'desc')->first();
        if ($latest) {
            $now = now();
            $created_at = $latest->created_at;

            $minutesDifference = $now->diffInMinutes($created_at);
            $hoursDifference = $now->diffInHours($created_at);
            $daysDifference = $now->diffInDays($created_at);

            if ($minutesDifference < 1) {
                return 'Just Now';
            } elseif ($minutesDifference < 60) {
                return $minutesDifference . ' minutes ago';
            } elseif ($hoursDifference < 24) {
                return $hoursDifference . ' hours ago';
            } else {
                return $daysDifference . ' days ago';
            }
        } else {
            return '';
        }
    }
}

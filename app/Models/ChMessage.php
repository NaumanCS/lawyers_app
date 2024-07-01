<?php

namespace App\Models;

use Chatify\Traits\UUID;
use Illuminate\Database\Eloquent\Model;

class ChMessage extends Model
{
    use UUID;

    protected $casts = [
        'attachment' => 'array',
    ];

    public function user()
    {
        return $this->hasOne(User::class, 'id', 'sender_id');
    }

    public function getAttachmentUrlsAttribute()
    {
        $attachments = $this->getAttribute('attachment');

        if ($attachments == null) {
            return null;
        }

        $attachments = is_string($attachments) ? json_decode($attachments, true) : $attachments;
        $urls = [];

        foreach ($attachments as $attachment) {
            $urls[] = asset('public/uploads/chat') . '/' . $attachment;
        }

        return $urls;
    }
}

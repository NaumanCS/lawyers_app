<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Chat extends Model
{
    use HasFactory;

    protected $fillable = ['sender_id', 'receiver_id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function sender()
    {
        return $this->hasOne(User::class, 'id', 'sender_id');
    }
    public function receiver()
    {
        return $this->hasOne(User::class, 'id', 'receiver_id');
    }

    public function messages()
    {
        return $this->hasMany(Message::class, 'chat_id', 'id');
    }
    public function scopeUserChats($query, $userId)
    {
        return $query->whereHas('participants', function ($query) use ($userId) {
            $query->where('user_id', $userId);
        });
    }
}

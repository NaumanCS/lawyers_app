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
}

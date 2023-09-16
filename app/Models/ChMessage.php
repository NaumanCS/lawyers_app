<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Chatify\Traits\UUID;

class ChMessage extends Model
{
    use UUID;

    public function user(){
        return $this->hasOne(User::class, 'id', 'sender_id');
    }
}

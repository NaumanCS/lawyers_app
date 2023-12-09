<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LawyersTimeSpan extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'service_id', 'time_spans','booked', 'extra_day_time_spans'];

    public function user(){
        return $this->belongsTo(User::class, 'id', 'user_id');
    }

}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CreateMeeting extends Model
{
    use HasFactory;
    protected $fillable=[
      'order_id',
      'meeting_name',
      'created_by',
      'meeting_with',
      'meeting_link',
      'date',
      'select_time_span'
    ];

    public function spanTime(){
      return $this->hasOne(LawyersTimeSpan::class,'id','select_time_span');
    }
    public function user(){
      return $this->hasOne(User::class,'id','meeting_with');
    }

    public function createdByUser(){
      return $this->hasOne(User::class,'id','created_by');
    }
}

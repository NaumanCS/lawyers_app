<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CreateMeeting extends Model
{
    use HasFactory;
    protected $fillable=[
      'meeting_name',
      'created_by',
      'meeting_with',
      'meeting_link',
    ];
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class feedBack extends Model
{
    use HasFactory;
    protected $fillable=[
       'lawyer_id',
       'customer_id',
        'rating',
        'review',
    ];
}

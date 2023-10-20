<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AccountDetail extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'user_type',
        'bank_account',
        'bank_account_title',
        'bank_name',
        'bank_account_number',
        'jazzcash_account',
        'jazzcash_title',
        'jazzcash_number',
    ];

    public function user(){
        return $this->hasOne(User::class,'id','user_id');
    }
}

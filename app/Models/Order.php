<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
    protected $fillable = [
        'lawyer_id',
        'customer_id',
        'category_id',
        'amount',
        'booking_date',
        'lawyer_status',
        'customer_status',
        'lawyer_location',
        'customer_location',
        'payment_slip',
        'status',
        'payment_status'

    ];

    public function getPaymentSlipAttribute(){
        if($this->attributes['payment_slip'] == null){
            return asset('admin/assets/img/uploadslip.jpg');
        }
        return asset('uploads/user') . '/' . $this->attributes['payment_slip'];
    }

    public function customer(){
        return $this->hasOne(User::class, 'id', 'customer_id');
    }

    public function lawyer(){
        return $this->hasOne(User::class, 'id', 'lawyer_id');
    }

    public function category(){
        return $this->hasOne(Category::class, 'id', 'category_id');
    }

   
}

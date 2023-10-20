<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory;
    protected $fillable = [
        'title', 'user_id', 'location', 'amount','days', 'start_day', 'end_day', 'start_time', 'end_time', 'add_extra_day', 'extra_day', 'extra_day_start_time', 'extra_day_end_time', 'cover_image'
    ];

    protected $casts = [
        'categories_id' => 'array',
    ];

    public function getCoverImageAttribute()
    {
        if ($this->attributes['cover_image'] == null) {
            return asset('front/assets/img/category/Category5.jpg');
        }
        return asset('uploads/lawyer/service') . '/' . $this->attributes['cover_image'];
    }

    public function category(){
        return $this->hasOne(Category::class, 'id', 'categories_id');
    }

    public function user(){
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function categories()
{
    return $this->belongsToMany(Category::class);
}

}

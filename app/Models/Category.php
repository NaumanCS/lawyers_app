<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;
    protected $fillable = [
        'image',
        'title',
        'description'
    ];

    public function getImageAttribute()
    {
        return asset('public/uploads/user') . '/' . $this->attributes['image'];
    }

    public function services()
    {
        return $this->belongsToMany(Service::class, 'services', 'id', 'categories_id');
    }

    public function lawyers()
    {
        return $this->hasMany(User::class, 'id', 'user_id');
    }
}

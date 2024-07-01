<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GeneralSetting extends Model
{
    use HasFactory;
    protected $fillable = [
        'nav_logo',
        'footer_logo',
        'title',
        'description',
    ];

    public function getNavLogoAttribute()
    {
        if ($this->attributes['nav_logo'] == null) {
            return asset('public/uploads/user.jpg');
        }
        return asset('public/uploads/user') . '/' . $this->attributes['nav_logo'];
    }

    public function getFooterLogoAttribute()
    {
        if ($this->attributes['footer_logo'] == null) {
            return asset('public/uploads/user.jpg');
        }
        return asset('public/uploads/user') . '/' . $this->attributes['footer_logo'];
    }
}

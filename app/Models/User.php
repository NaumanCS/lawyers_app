<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'phone',
        'role',
        'category_id',
        'password',
        'date_of_birth',
        'gender',
        'address',
        'country',
        'city',
        'state',
        'postal_code',
        'image',
        'is_document_submit',
        'degree',
        'certificates',
        'document_status',
        'reason'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function getImageAttribute()
    {
        if ($this->attributes['image'] == null) {
            return asset('uploads/user.jpg');
        }
        return asset('uploads/user') . '/' . $this->attributes['image'];
    }
    public function getDegreeAttribute(){
        if($this->attributes['degree'] == null){
            return asset('uploads/user.jpg');
        }
        return asset('uploads/lawyer/documents') . '/' . $this->attributes['degree'];
    }
    // public function getCertificatesAttribute(){
    //     if($this->attributes['certificates'] == null){
    //         return asset('uploads/user.jpg');
    //     }
    //     return asset('uploads/lawyer/documents') . '/' . $this->attributes['certificates'];
    // }

    public function getCustomerImageAttribute()
    {
        if ($this->attributes['image'] == null) {
            return asset('uploads/user.jpg');
        }
        return asset('uploads/user') . '/' . $this->attributes['image'];
    }

    public function isCustomer()
    {
        return $this->role === 'user';
    }

    public function isLawyer()
    {
        return $this->role === 'lawyer';
    }

    public function category(){
        return $this->hasOne(Category::class,'id','category_id');
    }

    public function time_spans(){
        return $this->hasMany(LawyersTimeSpan::class, 'user_id');
    }

    public function service(){
        return $this->hasOne(Service::class, 'user_id');
    } 
}

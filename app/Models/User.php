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
        'advocate',
        'high_court',
        'supreme_court',
        'advocate_licence',
        'high_court_licence',
        'supreme_court_licence',
        'experience_in_years',
        'qualification',
        'qualification_certificate',
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

    public function getHighCourtLicenceAttribute()
    {
        if ($this->attributes['high_court_licence'] == null) {
            return asset('admin/assets/img/licence.png');
        }
        return asset('uploads/lawyer/documents') . '/' . $this->attributes['high_court_licence'];
    }
    public function getSupremeCourtLicenceAttribute()
    {
        if ($this->attributes['supreme_court_licence'] == null) {
            return asset('admin/assets/img/licence.png');
        }
        return asset('uploads/lawyer/documents') . '/' . $this->attributes['supreme_court_licence'];
    }
    public function getQualificationCertificateAttribute()
    {
        if ($this->attributes['qualification_certificate'] == null) {
            return asset('admin/assets/img/qualification.jpg');
        }
        return asset('uploads/lawyer/documents') . '/' . $this->attributes['qualification_certificate'];
    }

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

    public function category()
    {
        return $this->hasOne(Category::class, 'id', 'category_id');
    }

    public function time_spans()
    {
        return $this->hasMany(LawyersTimeSpan::class, 'user_id');
    }

    public function service()
    {
        return $this->hasOne(Service::class, 'user_id');
    }

    public function accountDetail()
    {
        return $this->hasOne(AccountDetail::class, 'user_id');
    }

    public function lawyerCategory()
    {
        return $this->hasMany(Service::class, 'user_id', 'id');
    }

    public function lawyerTotalRating()
    {
        return $this->hasMany(feedBack::class, 'lawyer_id', 'id');
    }
}

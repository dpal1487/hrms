<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Admin extends Authenticatable
{
    use HasFactory;
    use Notifiable;

    protected $guard = 'admin';

    protected $fillable = ['first_name', 'last_name', 'email', 'password', 'social_id', 'social_type', 'email_verified_at', 'status'];

    public function image()
    {
        return $this->hasOne(Image::class, 'id', 'image_id');
    }
    public function address()
    {
        return $this->hasOne(UserAddress::class, 'user_id', 'id');
    }
    public function employee()
    {
        return $this->hasOne(Employee::class, 'user_id', 'id');
    }
    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = ['remember_token', 'two_factor_recovery_codes', 'two_factor_secret'];
}

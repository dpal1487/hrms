<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
  use HasFactory, Notifiable, HasApiTokens;

  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = [
    'id',
    'first_name',
    'last_name',
    'mobile',
    'email',
    'password',
    'google_id',
    'image_id',
    'facebook_id',
    'country_code',
  ];

  /**
   * The attributes that should be hidden for arrays.
   *
   * @var array
   */
  protected $hidden = [
    'password',
    'remember_token',
    'two_factor_recovery_codes',
    'two_factor_secret',
  ];

  /**
   * The attributes that should be cast to native types.
   *
   * @var array
   */
  protected $casts = [
    'email_verified_at' => 'datetime',
  ];

  public function findForPassport($mobile)
  {
    $mobile = 'mobile';
    return $this->where($mobile, $mobile)->first();
  }


  public function image()
  {
    return $this->hasOne(Image::class, 'id', 'image_id');
  }
  public function user_address()
  {
    return $this->hasOne(Address::class, 'user_id', 'id');
  }

  public function country()
  {
    return $this->hasOne(Country::class, 'id', 'country_id');
  }

  public function state()
  {
    return $this->hasOne(State::class, 'id', 'country_id');
  }

  public function address()
  {
    return $this->hasOne(Address::class, 'user_id', 'id');
  }

  public function reviews()
  {
    return $this->hasMany(Review::class, 'user_id', 'id');
  }
  public function review()
  {
    return $this->hasOne(Review::class, 'user_id', 'id');
  }

  public function items()
  {
    return $this->hasMany(Item::class, 'user_id', 'id');
  }

  public function followers()
  {
    return $this->hasMany(Follower::class, 'following_id', 'id');
  }

  public function following()
  {
    return $this->hasMany(Follower::class, 'follower_id', 'id');
  }
}

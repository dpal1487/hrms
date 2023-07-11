<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Tymon\JWTAuth\Contracts\JWTSubject;
use App\Models\Image;
use Illuminate\Support\Facades\Auth;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable
{
  use HasFactory, Notifiable;
  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = [
    'first_name',
    'last_name',
    'about',
    'email',
    'mobile',
    'password',
  ];
  /**
   * The attributes that should be hidden for arrays.
   *
   * @var array
   */
  protected $hidden = [
    'password',
    'remember_token',
    'created_at',
    'updated_at',
    'provider',
    'provider_id',
    'reset_otp',
    'status',
    'token'
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
  /**
   * Get the identifier that will be stored in the subject claim of the JWT.
   *
   * @return mixed
   */

   public function user(){
    return $this->hasOne(UserAddress::class,'user_id','id');
  }

  public function image()
  {
    return $this->hasOne(Image::class, 'id', 'image_id');
  }
  public function items()
  {
    return $this->hasMany(Item::class, 'user_id', 'id');
  }
  public function followers()
  {
    return $this->hasMany(Follower::class, 'following_id', 'id');
  }
  public function followings()
  {
    return $this->hasMany(Follower::class, 'follower_id', 'id');
  }
  public function review()
  {
    return $this->hasOne(CustomerReview::class, 'user_id', 'id');
  }
  public function reviews()
  {
    return $this->hasMany(UserReview::class, 'user_id', 'id');
  }
  public function location()
  {
    return $this->hasOne(Address::class, 'user_id', 'id');
  }

  public function address()
  {
    return $this->hasOne(UserAddress::class, 'user_id', 'id');
  }



  public function isFollowing()
  {
    $user = Auth::guard('api')->user();
    if ($user) {
      return $this->hasOne(Follower::class, 'following_id', 'id')->where('follower_id', '=', $user->id);
    }
    return ($this->hasOne(Follower::class, 'following_id', 'id')->where('follower_id', '=', 0));
  }
  public function country(){
    return $this->hasOne(Country::class,'id','country_id');
  }
}

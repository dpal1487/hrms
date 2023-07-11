<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserReview extends Model
{

  public function user()
  {
    return $this->hasOne(User::class, 'id', 'user_id');
  }
  public function users()
  {
    return $this->hasMany(User::class, 'id', 'user_id');
  }
  public function review()
    {
        return $this->hasOne(Review::class , 'id' , 'review_id');
    }
    public function reviews()
    {
        return $this->hasMany(Review::class , 'id' , 'review_id');
    }
}

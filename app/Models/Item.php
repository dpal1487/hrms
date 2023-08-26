<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Item extends Model
{
  protected $hidden = ['user_id',];
  protected $fillable = ['id', 'user_id', 'name', 'slug', 'category_id', 'base_url', 'description', 'rent_price', 'time_id', 'security_price', 'from_date', 'to_date', 'status_id'];

  public function attributes()
  {
    return $this->hasMany(ItemAttribute::class, 'item_id', 'id');
  }
  public function customer()
  {
    return $this->hasOne(ItemCustomer::class, 'item_id', 'id');
  }
  public function customers()
  {
    return $this->hasMany(ItemCustomer::class, 'item_id', 'id');
  }
  public function favourties()
  {
    return $this->hasMany(Favourite::class, 'item_id', 'id');
  }
  public function image()
  {
    return $this->hasOne(ItemImage::class, 'item_id', 'id');
  }
  public function images()
  {
    return $this->hasMany(ItemImage::class, 'item_id', 'id');
  }
  public function location()
  {
    return $this->hasOne(ItemLocation::class, 'item_id', 'id');
  }
  public function reviews()
  {
    return $this->hasMany(ItemReview::class, 'item_id', 'id');
  }
  public function review()
  {
    return $this->hasOne(ItemReview::class, 'item_id', 'id');
  }
  public function time()
  {
    return $this->hasOne(Time::class, 'id', 'time_id');
  }
  public function category()
  {
    return $this->hasOne(Category::class, 'id', 'category_id');
  }
  public function visits()
  {
    return $this->hasMany(ItemVisit::class, 'item_id', 'id');
  }
  public function status()
  {
    return $this->hasOne(ItemStatus::class, 'id', 'status_id');
  }
  public function user()
  {
    return $this->hasOne(User::class, 'id', 'user_id');
  }
  public function attribute()
  {
    return $this->hasOne(ItemAttribute::class, 'item_id', 'id');
  }
  public function isFavourite()
  {
    // $user = Auth::guard('api')->user();
    $user = Auth::user();
    if ($user) {
      return $this->hasOne(Favourite::class, 'item_id', 'id')->where('user_id', $user->id);
    }
    return $this->hasOne(Favourite::class, 'item_id', 'id')->where('user_id', 0);
  }

  public function total_ratings()
  {
    $ratings = 0;
    $reviews = $this->reviews;
    if (!empty($reviews)) {
      $ratings = array_sum(array_column($reviews->toArray(), 'rating')) / count($reviews);
    }
    return $ratings;
  }

  
}

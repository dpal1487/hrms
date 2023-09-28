<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Review;
use App\Models\User;
use App\Models\Item;

class ItemReview extends Model
{
  protected $fillable = ['item_id', 'user_id', 'review_id'];

  public function user()
  {
    return $this->hasOne(User::class, 'id', 'user_id');
  }
  public function item()
  {
    return $this->belongsTo(Item::class, 'id', 'item_id');
  }
  public function reviews()
  {
    return $this->hasMany(Review::class, 'id', 'review_id');
  }
  public function review()
  {
    return $this->hasOne(Review::class, 'id', 'review_id');
  }

  public function report()
  {
    return $this->hasOne(Report::class, 'source_id', 'review_id');
  }
}

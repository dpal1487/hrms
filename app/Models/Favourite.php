<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Favourite extends Model
{
  protected $table = 'item_favourites';
  protected $fillable = ['user_id', 'item_id'];
  public function item()
  {
    return $this->hasOne(Item::class, 'id', 'item_id');
  }
  public function user()
  {
    return $this->hasOne(User::class, ' id', 'user_id');
  }
}

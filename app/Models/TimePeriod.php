<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TimePeriod extends Model
{
    protected $fillable = ['category_id', 'time_id'];

  public function time()
  {
    return $this->hasOne(Time::class, 'id', 'time_id');
  }
 
  public function category()
  {
    return $this->hasOne(Category::class, 'id', 'category_id');
  }
  public function categories()
  {
    return $this->hasMany(Category::class, 'id', 'category_id');
  }
}

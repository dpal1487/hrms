<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Time extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'description', 'status'];

    public function category()
  {
    return $this->hasOne(Category::class, 'id', 'category_id');
  }
  public function categories()
  {
    return $this->hasMany(TimePeriod::class, 'id', 'category_id');
  }
  public function times()
  {
    return $this->hasMany(TimePeriod::class, 'id', 'time_id');
  }
}

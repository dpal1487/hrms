<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CategoryAttributeValue extends Model
{
    use HasFactory;
  protected $fillable = ['category_id', 'attribute_id' , 'value_id'];

  public function categoryAttribute()
  {
        return $this->hasOne(Category::class , 'id' , 'category_id');
  }

}

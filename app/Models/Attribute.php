<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attribute extends Model
{
  use HasFactory;
  protected $fillable = ['name', 'category_id', 'field', 'key', 'input_type', 'render_as', 'display_order','data_type' ,'parent_id','status' ,'description'];
  protected $hidden = ['created_at', 'updated_at', 'category_id'];


  public function parent()
  {
    return $this->hasOne(Attribute::class, 'id','parent_id');
  }
  public function attribute()
  {
    return $this->hasMany(Attribute::class, 'parent_id');
  }
  public function values()
  {
    return $this->hasMany(AttributeValue::class,'attribute_id', 'id');
  }
  public function rule()
  {
    return $this->hasOne(AttributeRule::class, 'attribute_id' , 'id');
  }

  public function rules()
  {
    return $this->hasMany(AttributeRule::class, 'attribute_id' , 'id');
  }

  public function category()
  {
    return $this->hasOne(Category::class, 'id', 'category_id');
  }

  public function categories()
  {
    return $this->hasMany(CategoryAttribute::class, 'attribute_id', 'id');
  }

  public static function boot() {
    parent::boot();

    static::deleting(function($attribute) { // before delete() method call this
         $attribute->values()->delete();
         $attribute->rules()->delete();
         // do the rest of the cleanup...
    });
}

}

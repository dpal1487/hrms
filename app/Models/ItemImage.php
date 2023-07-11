<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Image;

class ItemImage extends Model
{
  public $timestamps = false;
  protected $fillable = [
    'item_id',
    'image_id',
  ];
  public function image()
  {
    return $this->hasOne(Image::class, 'id', 'image_id');
  }
  public function images()
  {
    return $this->hasMany(Image::class, 'id', 'image_id');
  }
  public function file()
  {
    return $this->hasOne(File::class , 'id' , 'image_id');
  }

  public function files()
  {
    return $this->hasMany(File::class , 'id' , 'image_id');
  }
  public function item()
  {
    return $this->hasOne(Item::class , 'id' , 'item_id');
  }
  public function items()
  {
    return $this->hasMany(Item::class , 'id' , 'item_id');
  }
}

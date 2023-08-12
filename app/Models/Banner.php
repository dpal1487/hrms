<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Banner extends Model
{
  use HasFactory;

  protected $fillable = [
    'title',
    'description',
    'url',
    'image_id',
    'status'
  ];
  public function image()
  {
    return $this->hasOne(Image::class, 'id', 'image_id');
  }


  public static function boot()
  {
    parent::boot();

    static::deleting(function ($banner) { // before delete() method call this
      // $banner->image()->delete();
      Storage::disk('public')->delete($banner->image);
      // do the rest of the cleanup...
    });
  }
}

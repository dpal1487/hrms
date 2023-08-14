<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\File;
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
      File::delete($banner->image());
    });
  }
}

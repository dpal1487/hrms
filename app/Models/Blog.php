<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Blog extends Model
{
    protected $fillable = ['title', 'content', 'slug', 'image_id', 'published'];
    public function image()
    {
        return $this->hasOne(Image::class, 'id', 'image_id');
    }
    public function status()
    {
        return $this->hasOne(StatusValue::class, 'id', 'published');
    }
    public static function boot()
    {
        parent::boot();

        static::deleting(function ($industry) {
            // before delete() method call this
            $industry->image()->delete();
            // do the rest of the cleanup...
        });
    }
}

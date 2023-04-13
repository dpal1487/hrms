<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Industry extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'image_id', 'status'];

    public function image()
    {
        return $this->hasOne(Image::class, 'id', 'image_id');
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

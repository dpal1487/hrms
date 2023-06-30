<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory;

    protected $fillable = ['slug', 'name', 'page', 'description', 'image_id'];

    public function image()
    {
        return $this->hasOne(Image::class, 'id', 'image_id');
    }
}

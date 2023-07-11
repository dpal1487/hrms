<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CategoryBanner extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id',
        'image_id',
        'order_by'
    ];

    public function category()
    {
        return $this->hasOne(Category::class , 'id' , 'category_id');
    }

    public function banner()
    {
        return $this->hasOne(Image::class , 'id' , 'image_id');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CategoryAttribute extends Model
{
    use HasFactory;
    protected $fillable = ['attribute_id', 'category_id'];

    public function categoryAttribute()
    {
        return $this->hasOne(Category::class, 'id', 'category_id');
    }
}

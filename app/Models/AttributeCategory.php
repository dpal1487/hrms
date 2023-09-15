<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AttributeCategory extends Model
{
    use HasFactory;

    protected $fillable = ['attribute_id', 'category_id'];

    public function attributeCategory()
    {
        return $this->hasOne(Category::class, 'id', 'category_id');
    }
}

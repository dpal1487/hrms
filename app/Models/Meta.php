<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Meta extends Model
{
    use HasFactory;

    protected $fillable = [
        'tag',
        'description',
        'keywords'
    ];

    public function meta()
    {
        return $this->hasOne(Category::class , 'meta_id' , 'id');
    }
}

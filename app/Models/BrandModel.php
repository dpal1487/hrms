<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BrandModel extends Model
{
    use HasFactory;
    protected $fillable = [
        'name' , 'slug' , 'status', 'brand_id'
];
public function brand()
{
    return $this->belongTo(Brand::class , 'id' , 'brand_id');
}
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Brand extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'slug', 'category_id', 'image_id', 'description', 'status'
    ];

    public function category()
    {
        return $this->hasOne(Category::class, 'id', 'category_id');
    }

    public function image()
    {
        return $this->hasOne(Image::class, 'id', 'image_id');
    }

    public function models()
    {
        return $this->hasMany(BrandModel::class, 'brand_id', 'id');
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($brand) {
            $brand->slug = Str::slug($brand->name);
        });

        static::deleting(function ($brand) { // before delete() method call this
            $brand->image()->delete();
            $brand->models()->delete();
            // do the rest of the cleanup...
        });
    }
}

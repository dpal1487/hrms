<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = ['name', 'slug', 'parent_id', 'meta_id', 'description', 'keywords', 'image_id', 'status'];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($category) {
            $category->slug = Str::slug($category->name);
        });

        static::deleting(function ($category) {
            // before delete() method call this
            $category->image()->delete();
            $category->meta()->delete();
            $category->banner()->delete();
            // do the rest of the cleanup...
        });
    }

    public function image()
    {
        return $this->hasOne(Image::class, 'id', 'image_id');
    }

    public function child()
    {
        return $this->hasOne(Category::class, 'parent_id', 'id');
    }
    public function children()
    {
        return $this->hasMany(Category::class, 'parent_id', 'id');
    }
    public function parent()
    {
        return $this->hasOne(Category::class, 'parent_id', 'id');
    }
    public function childrens()
    {
        return $this->hasMany(Category::class, 'parent_id', 'id');
    }
    public function attributes()
    {
        return $this->hasMany(Attribute::class, 'category_id', 'id');
    }
    public function priceCondition()
    {
        return $this->hasMany(TimePeriod::class, 'category_id', 'id');
    }
    public function meta()
    {
        return $this->hasOne(Meta::class, 'id', 'meta_id');
    }

    public function banner()
    {
        return $this->hasOne(CategoryBanner::class, 'category_id', 'id');
    }

    public function times()
    {
        return $this->hasMany(TimePeriod::class, 'time_id', 'id');
    }
}

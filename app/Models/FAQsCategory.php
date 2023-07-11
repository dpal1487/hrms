<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;


class FAQsCategory extends Model
{
    use HasFactory;
    protected $table = 'faq_categories';
    protected $fillable = [
        'title' , 'slug' , 'image_id' , 'status',
];

public function faqcategory()
{
    return $this->hasOne(Faq::class , 'category_id' , 'id');
}
public function faqcategorys()
{
    return $this->hasMany(Faq::class , 'category_id' , 'id');
}

public function image()
{
    return $this->hasOne(Image::class , 'id' , 'image_id');
}


protected static function boot() {
        parent::boot();

        static::creating(function ($faq) {
            $faq->slug = Str::slug($faq->title);
        });
        static::deleting(function($faq) { // before delete() method call this
            $faq->image()->delete();
            // $faq->models()->delete();
            // do the rest of the cleanup...
       });


    }
}

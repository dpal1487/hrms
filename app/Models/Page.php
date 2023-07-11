<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Page extends Model
{
    use HasFactory;

    protected $fillable = [
        'title' , 'heading' , 'status', 'slug' , 'meta_id'
];

protected static function boot() {
        parent::boot();

        static::creating(function ($page) {
            $page->slug = Str::slug($page->heading);
        });
    }

    public function meta()
    {
        return $this->hasOne(Meta::class , 'id' , 'meta_id');
    }
}

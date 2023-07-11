<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;


class NotificationType extends Model
{
    use HasFactory;

    protected $fillable = [
        'label', 'slug' ,'description' , 'status'
];


    protected static function boot() {
        parent::boot();

        static::creating(function ($notification) {
            $notification->slug = Str::slug($notification->label);
        });

    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;


class Plan extends Model
{
    use HasFactory;

    protected $fillable = ['slug', 'name', 'description', 'is_active', 'price', 'stripe_id', 'currency', 'sort_order'];

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($plan) {
            $plan->slug = Str::slug($plan->name);
        });
    }
}

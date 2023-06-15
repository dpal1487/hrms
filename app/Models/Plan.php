<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Plan extends Model
{
    use HasFactory;

    protected $fillable = ['slug', 'name', 'sort_description', 'description', 'is_active', 'price', 'interval', 'stripe_plan', 'currency_id', 'sort_order', 'start_date', 'end_date'];

    public function currency()
    {
        return $this->hasOne(Currency::class, 'id', 'currency_id');
    }

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($plan) {
            $plan->slug = Str::slug($plan->name);
        });
    }
}

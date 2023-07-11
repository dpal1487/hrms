<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Ramsey\Uuid\Uuid;
use Illuminate\Support\Str;


class Plan extends Model
{
    use HasFactory;
    protected $primaryKey = 'id';
    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable =[
        'slug',
        'name',
        'category_id',
        'no_of_ads',
        'sort_description',
        'description',
        'is_active',
        'price',
        'signup_fee',
        'currency',
        'trial_period',
        'trial_interval',
        'invoice_period',
        'invoice_interval',
        'grace_period',
        'grace_interval',
        'prorate_day',
        'prorate_period',
        'prorate_extend_due',
        'active_subscribers_limit',
        'sort_order',
];

protected static function boot()
    {
        parent::boot();
        static::creating(function ($plan) {
            // $model->setAttribute($model->getKeyName(), Uuid::uuid4());
            $plan->slug = Str::slug($plan->name);

        });
    }
}

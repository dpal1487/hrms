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

    protected $fillable = [
        'slug',
        'name',
        'category_id',
        'no_of_ads',
        'sort_description',
        'description',
        'status',
        'price',
        
        'currency',
        'plan_id',
        'sort_order',
    ];

    public function category()
    {
        return $this->hasOne(Category::class, 'id', 'category_id');
    }

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($plan) {
            // $model->setAttribute($model->getKeyName(), Uuid::uuid4());
            $plan->slug = Str::slug($plan->name);
        });
    }
}

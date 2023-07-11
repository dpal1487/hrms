<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subscription extends Model
{
    use HasFactory;
    protected $fillable=['user_id','plan_id','order_id','payment_id','quantity','status','start_at','end_at'];
    protected $primaryKey = 'id';
    protected $keyType = 'string';
    public $incrementing = false;
    protected static function boot()
    {
        parent::boot();
        static::creating(function (Model $model) {
            $model->setAttribute($model->getKeyName(), now()->timestamp);
        });
    }
    public function plan(){
        return $this->hasOne(Plan::class,'id','plan_id');
    }
    public function user(){
        return $this->hasOne(User::class,'id','user_id');
    }
    public function order(){
        return $this->hasOne(Order::class,'id','order_id');
    }
    public function payment(){
        return $this->hasOne(Payment::class,'id','payment_id');
    }
}

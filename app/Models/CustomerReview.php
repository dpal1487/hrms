<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomerReview extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id','content','seen','rating','ip_address'
];

    public function user()
    {
        return $this->hasOne(User::class , 'id' , 'user_id');
    }
    public function reviews()
    {
        return $this->hasMany(Review::class , 'id' , 'review_id');
    }
    public function review()
    {
        return $this->hasOne(Review::class , 'id' , 'review_id');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ItemReviewLike extends Model
{
    use HasFactory;

    protected $fillable = [
        'review_id',
        'user_id'
    ];

    public function review()
    {
        return $this->hasOne(Review::class, 'id', 'review_id');
    }
    public function user()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }
}

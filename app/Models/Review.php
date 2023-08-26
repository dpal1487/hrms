<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory;
    protected $fillable = ['content', 'rating', 'title'];

    public function review()
    {
        return $this->belongsTo(UserReview::class, 'review_id', 'id');
    }

    public function reviews()
    {
        return $this->hasMany(ItemReview::class, 'review_id', 'id');
    }
  
}

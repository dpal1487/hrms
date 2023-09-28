<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'type_id', 'source_id'];

    public function review()
    {
        return $this->hasOne(Review::class, 'id', 'source_id');
    }
    public function reviews()
    {
        return $this->hasMany(Review::class, 'id', 'source_id');
    }
    public function user()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }
}

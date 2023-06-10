<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Support extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'email', 'subject', 'priority', 'description'];

    public function user()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }
}

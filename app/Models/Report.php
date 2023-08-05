<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'type_id', 'source_id'];

    public function item()
    {
        return $this->hasOne(Item::class, 'id', 'source_id');
    }
    public function items()
    {
        return $this->hasMany(Item::class, 'id', 'source_id');
    }
    public function user()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }
}

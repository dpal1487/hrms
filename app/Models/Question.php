<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    use HasFactory;
    protected $fillable = ['industry_id', 'question_key', 'text', 'language', 'type'];

    function industry()
    {
        return $this->hasOne(Industry::class, 'id', 'industry_id');
    }
}

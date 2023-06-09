<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Answer extends Model
{
    use HasFactory;

    protected $fillable = ['question_id', 'answer', 'order_by'];

    public function question()
    {
        return $this->hasOne(Question::class, 'id', 'question_id');
    }
}

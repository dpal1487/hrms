<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DecisionMaker extends Model
{
    use HasFactory;
    protected $fillable = ['title', 'industry_id', 'order_by'];

    function industry()
    {
        return $this->hasOne(Industry::class, 'id', 'industry_id');
    }
}

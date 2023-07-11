<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rule extends Model
{
    use HasFactory;
    protected $fillable = ['rule' , 'value' , 'message'];

    public function rule()
    {
        return $this->hasOne(AttributeRule::class , 'rule_id' , 'id');
    }
    public function rules()
    {
        return $this->hasMany(AttributeRule::class , 'rule_id' , 'id');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AttributeRule extends Model
{
    use HasFactory;

    protected  $fillable = [
        'attribute_id','rule_id'
];

public function attributeRule()
    {
        return $this->hasOne(Rule::class , 'id' , 'rule_id');
    }
}

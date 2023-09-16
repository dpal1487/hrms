<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AttributeValue extends Model
{
    use HasFactory;

    protected $fillable = [
        'attribute_value','attribute_id','status'
    ];

    public function attribute()
    {
        return $this->hasOne(Attribute::class , 'id' , 'attribute_id');
    }

    public function attributeCategory()
    {
        return $this->hasOne(CategoryAttributeValue::class , 'value_id' , 'id');
    }
}

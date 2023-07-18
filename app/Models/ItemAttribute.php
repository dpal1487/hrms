<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ItemAttribute extends Model
{
  protected $fillable = [
    'item_id',
    'attribute_id',
    'attribute_value',
  ];
  public function attribute()
  {
    return $this->hasOne(Attribute::class, 'id', 'attribute_id');
  }
  public function item()
  {
    return $this->hasOne(Item::class, 'id', 'item_id');
  }
}

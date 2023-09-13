<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ItemLocation extends Model
{
  public $timestamps = false;
  protected $fillable = [
    'address_id',
    'item_id',
  ];
  public function address()
  {
    return $this->hasOne(Address::class,'id','address_id');
  }
  public function item()
  {
    return $this->hasOne(Item::class , 'id' , 'item_id');
  }


}

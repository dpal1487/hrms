<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
  use HasFactory;
  protected $fillable = ['address','country', 'state', 'city','locality', 'pincode','latitude', 'longitude'];

  public function address(){
    return $this->hasOne(UserAddress::class,'address_id','id');
  }

  public function location()
  {
    return $this->hasOne(ItemLocation::class , 'address_id' , 'id');
  }

}

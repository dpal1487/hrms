<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
class Address extends Model
{
  use HasFactory;
  protected $fillable = ['address','name','phone','is_primary','address_type_id', 'state', 'city', 'locality', 'pincode', 'latitude', 'longitude'];
  public function address()
  {
    return $this->hasOne(UserAddress::class, 'address_id', 'id');
  }
  public function addressType()
  {
    return $this->hasOne(AddressType::class, 'id','address_type_id');
  }

  public function location()
  {
    return $this->hasOne(ItemLocation::class, 'address_id', 'id');
  }

  public function country()
  {
    return $this->hasOne(Country::class, 'id', 'country_id');
  }
}

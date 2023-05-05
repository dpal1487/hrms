<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    use HasFactory;

    protected $fillable = ['address_line_1', 'address_line_2', 'city', 'state', 'country_id', 'pincode'];

    public function country()
    {
        return $this->hasOne(Country::class, 'id', 'country_id');
    }
}

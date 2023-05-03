<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClientAddress extends Model
{
    use HasFactory;
    public function address()
    {
        return $this->hasOne(Address::class, 'id', 'address_id');
    }
    public function addresss()
    {
        return $this->hasMany(Address::class, 'id', 'address_id');
    }
}

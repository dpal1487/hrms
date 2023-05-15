<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SupplierAddress extends Model
{
    use HasFactory;
    protected $fillable = ['supplier_id', 'address_id'];

    public function address()
    {
        return $this->hasOne(Address::class, 'id', 'address_id');
    }
}

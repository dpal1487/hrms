<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    use HasFactory;

    protected $fillable = ['company_id', 'name', 'sort_name', 'status'];

    public function company()
    {
        return $this->hasOne(Company::class, 'id', 'company_id');
    }

    public function client_address()
    {
        return $this->hasOne(ClientAddress::class, 'client_id', 'c_id');
    }
    public function client_addresss()
    {
        return $this->hasMany(ClientAddress::class, 'client_id', 'c_id');
    }
}

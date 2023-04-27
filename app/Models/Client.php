<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    use HasFactory;

    protected $table = 'clients';

    protected $fillable = ['id', 'company_id', 'name', 'sort_name', 'status'];

    public function company()
    {
        return $this->hasOne(Company::class, 'id', 'company_id');
    }

    public function client_address()
    {
        return $this->hasOne(ClientAddress::class, 'client_id', 'id');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Company extends UID
{
    use HasFactory;
    protected $fillable = ['user_id', 'company_type', 'subdomain', 'company_size_id', 'corporation_type_id', 'contact_email', 'tax_number', 'company_name', 'description', 'website', 'contact_number'];

    public function user()
    {
        return $this->hasOne(User::class , 'id' , 'user_id');
    }

    public function FunctionName(Type $var = null)
    {
        # code...
    }
}

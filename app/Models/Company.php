<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Company extends UID
{
    use HasFactory;
    protected $fillable = ['user_id', 'company_type', 'subdomain', 'company_size_id', 'corporation_type_id', 'contact_email', 'tax_number', 'company_name', 'description', 'website', 'contact_number','account_plan'];

    public function user()
    {
        return $this->hasOne(User::class , 'id' , 'user_id');
    }

    public function size()
    {
        return $this->hasOne(CompanySize::class , 'id' , 'company_size_id');
    }
    public function corporationtype()
    {
        return $this->hasOne(CorporationType::class , 'id','corporation_type_id');
    }
    public function company_addresss()
    {
        return $this->hasMany(CompanyAddress::class , 'company_id' , 'id');
    }
    public function company_account()
    {
        return $this->hasMany(CompanyAccount::class , 'company_id' , 'id');
    }
}

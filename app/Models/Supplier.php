<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Supplier extends UID
{
    use HasFactory;
    protected $fillable = ['company_id', 'supplier_name', 'display_name', 'website', 'skype_profile', 'linkedIn_profile', 'description', 'status'];

    public function company()
    {
        return $this->hasOne(Company::class, 'id', 'company_id');
    }

    public function companies()
    {
        return $this->hasMany(Company::class, 'id', 'company_id');
    }
}

<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Supplier extends UID
{
    use HasFactory;
    protected $fillable = ['company_id', 'supplier_name', 'display_name', 'website', 'skype_profile', 'linkedIn_profile', 'description', 'status'];

    public function address()
    {
        return $this->hasOne(SupplierAddress::class, 'supplier_id', 'id');
    }
    public function account()
    {
        return $this->hasOne(SupplierAccount::class, 'supplier_id', 'id');
    }
    public function company()
    {
        return $this->hasOne(Company::class, 'id', 'company_id');
    }

    public function companies()
    {
        return $this->hasMany(Company::class, 'id', 'company_id');
    }

    protected static function boot()
    {
        parent::boot();
        static::deleting(function ($supplier) {
            $supplier->account()->delete();
            $supplier->address()->delete();
        });
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CompanyAddress extends Model
{
    use HasFactory;
    protected $fillable = ['address_id', 'company_id'];

    public function address()
    {
        return $this->hasOne(Address::class, 'id', 'address_id');
    }
    public function addresses()
    {
        return $this->hasMany(Address::class, 'id', 'address_id');
    }

    public static function boot()
    {
        parent::boot();

        static::deleting(function ($address) {
            // before delete() method call this
            $address->address()->delete();
            // do the rest of the cleanup...
        });
    }

    // public function company()
    // {
    //     return $this->hasOne(Company::class, 'id', 'company_id');
    // }
}

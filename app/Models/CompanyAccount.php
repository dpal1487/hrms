<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CompanyAccount extends Model
{
    use HasFactory;
    protected $fillable = ['company_id', 'account_id'];

    public function account()
    {
        return $this->hasOne(Account::class, 'id', 'account_id');
    }
    public function accounts()
    {
        return $this->hasMany(Account::class, 'id', 'account_id');
    }

    public static function boot()
    {
        parent::boot();

        static::deleting(function ($account) {
            $account->account()->delete();
        });
    }
}

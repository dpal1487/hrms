<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CompanyEmail extends UID
{
    use HasFactory;
    protected $fillable = ['is_primary', 'company_id', 'email_address'];
    public function company()
    {
        return $this->hasOne(Company::class, 'id', 'company_id');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CompanyUser extends Model
{
    use HasFactory;
    public function company()
    {
        return $this->hasOne(Company::class, 'user_id', 'user_id');
    }
}

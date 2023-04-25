<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CompanyInvoice extends UID
{
    use HasFactory;
    protected $fillable = ['company_id', 'invoice_id'];

    // public function company()
    // {
    //     return $this->hasOne(Company::class, 'id', 'company_id');
    // }
}

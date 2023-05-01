<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AccountDetail extends Model
{
    use HasFactory;
    protected $fillable = ['bank_name', 'bank_address', 'beneficiary_name', 'account_number', 'routing_number', 'swift_code', 'ifsc_code', 'sort_code', 'pan_number'];

   
}

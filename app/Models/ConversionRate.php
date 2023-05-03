<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ConversionRate extends Model
{
    use HasFactory;
    protected $fillable = ['currency_name', 'currency_value', 'conversion_rate', 'inr_amount', 'actual_value' ,'status'];
}

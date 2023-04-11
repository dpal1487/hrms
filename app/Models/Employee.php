<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory;

    protected $fillable = ['code', 'date_of_joining', 'number', 'qualification', 'emergency_number', 'pan_number', 'father_name', 'formalities', 'salary', 'offer_acceptance', 'probation_period', 'date_of_confirmation', 'notice_period', 'last_working_day', 'full_final', 'department_id'];
}

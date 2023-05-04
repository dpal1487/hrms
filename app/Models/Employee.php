<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory;

    protected $fillable = ['code', 'date_of_joining', 'number', 'qualification', 'emergency_number', 'pan_number', 'father_name', 'formalities', 'salary', 'offer_acceptance', 'probation_period', 'date_of_confirmation', 'notice_period', 'last_working_day', 'full_final', 'department_id', 'user_id', 'company_id'];

    public function user()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    public function image()
    {
        return $this->hasOne(Image::class, 'id', 'image_id');
    }

    public function address()
    {
        return $this->hasOne(EmployeeAddress::class, 'employee_id', 'id');
    }


    public static function boot()
    {
        parent::boot();

        static::deleting(function ($employee) {
            // before delete() method call this
            $employee->user()->delete();
            // do the rest of the cleanup...
        });
    }
}

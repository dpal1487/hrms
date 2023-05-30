<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Mail\ContactMail;
use Illuminate\Support\Facades\Mail as FacadesMail;

class Contact extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'email', 'mobile', 'subject', 'message', 'ip_address'];


    public static function boot()
    {

        parent::boot();

        static::created(function ($item) {

            $adminEmail = "your_admin_email@gmail.com";
            FacadesMail::to($adminEmail)->send(new ContactMail($item));
        });
    }
}

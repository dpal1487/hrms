<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends UID
{
    use HasFactory;
    protected $fillable = ['client_id', 'company_id', 'gst_status', 'invoice_number', 'conversion_rate', 'invoice_date', 'invoice_due_date', 'total_amount_usd', 'total_amount_inr', 'notes', 'status'];

    public function company()
    {
        return $this->hasOne(Company::class, 'id', 'company_id');
    }

    // public static function boot()
    // {
    //     parent::boot();

    //     static::deleting(function ($industry) {
    //         // before delete() method call this
    //         $industry->image()->delete();
    //         // do the rest of the cleanup...
    //     });
    // }
}

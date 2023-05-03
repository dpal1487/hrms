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
        return $this->hasOne(CompanyInvoice::class, 'company_id', 'company_id');
    }
    public function client()
    {
        return $this->hasOne(Client::class, 'c_id', 'client_id');
    }
    public function items()
    {
        return $this->hasMany(InvoiceItem::class, 'invoice_id', 'id');
    }
    public function company_address()
    {
        return $this->hasOne(CompanyAddress::class, 'company_id', 'company_id');
    }
    public function client_address()
    {
        return $this->hasOne(ClientAddress::class, 'client_id', 'client_id');
    }
    public function client_addresss()
    {
        return $this->hasMany(ClientAddress::class, 'client_id', 'client_id');
    }

    public static function boot()
    {
        parent::boot();

        static::deleting(function ($invoice) {
            // before delete() method call this
            $invoice->company()->delete();
            $invoice->item()->delete();
            // do the rest of the cleanup...
        });
    }
}

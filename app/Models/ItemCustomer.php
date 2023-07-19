<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ItemCustomer extends Model
{
  protected $fillable = ['item_id', 'document_id', 'full_name', 'rental_stauts', 'mobile', 'rental_date', 'return_date', 'security_pay', 'email_address'];
  public function item()
  {
    return $this->hasOne(Item::class, 'id', 'item_id');
  }
  public function document()
  {
    return $this->hasOne(File::class, 'id', 'document_id');
  }
}

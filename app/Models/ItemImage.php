<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ItemImage extends Model
{
  public $timestamps = false;
  protected $fillable = [
    'item_id',
    'name',
    'base_url',
    'base_path',
  ];
}

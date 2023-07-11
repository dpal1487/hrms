<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
  public function sender()
  {
    return $this->hasOne(User::class, 'id', 'sender_id');
  }
  public function type()
  {
    return $this->hasOne(NotificationType::class, 'id', 'type_id');
  }
  public function review()
  {
    return $this->hasOne(Rating::class, 'id', 'source_id');
  }
}
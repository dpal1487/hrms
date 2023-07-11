<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Facades\Auth;
class Participant extends Model
{
  public function user()
  {
    return $this->hasOne(User::class, 'id', 'users_id');
  }
  public function lastMessage()
  {
    return $this->hasOne(Message::class, 'conversation_id', 'conversation_id');
  }
  public function messages()
  {
    return $this->hasMany(Message::class, 'conversation_id', 'conversation_id')->orderBy('id','desc');
  }
  public function unreadMessages()
  {
    $user = Auth::user();
    return $this->hasMany(Message::class, 'conversation_id', 'conversation_id')->where(['is_read'=>0])->where('sender_id', '!=', $user->id);
  }
}

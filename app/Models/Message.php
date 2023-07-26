<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Message extends UID
{
    protected $fillable = ['message', 'conversation_id', 'sender_id', 'message_type', 'is_read', 'body', 'thread_id', 'user_id'];
}

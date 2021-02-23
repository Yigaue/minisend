<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SenderRecipient extends Model
{
    protected $table = 'sender_recipient';
    protected $fillable = ['user_id', 'email_id', 'recipient_id'];
}

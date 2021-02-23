<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Email extends Model
{
    protected $fillable = ['from', 'alias', 'subject', 'content'];

    Public function attachments()
    {
        return $this->hasMany(Attachment::class);
    }

    Public function recipients()
    {
        return $this->belongsToMany(Recipient::class, 'sender_recipient');
    }
}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Email extends Model
{
    protected $fillable = ['alias', 'subject', 'text_content', 'html_content'];

    Public function attachments()
    {
        return $this->hasMany(Attachment::class);
    }

    Public function recipients()
    {
        return $this->belongsToMany(Recipient::class, 'sender_recipient');
    }
}

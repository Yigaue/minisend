<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Email extends Model
{
    protected $fillable = ['subject', 'content'];

    Public function attachments()
    {
        return $this->hasMany(Attachment::class);
    }

    Public function recipients()
    {
        return $this->belongsToMany(Recipient::class, 'sender_recipient');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

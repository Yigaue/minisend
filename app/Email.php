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

    public function sender()
    {
        return $this->belongsTo(User::class);
    }
}

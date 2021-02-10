<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Attachment extends Model
{
    protected $fillable = ['file_link'];

    Public function email()
    {
        return $this->belongsTo(Email::class);
    }
}

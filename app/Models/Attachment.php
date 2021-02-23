<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Attachment extends Model
{
    protected $fillable = ['file_name', 'email_id', 'file_url'];

    Public function email()
    {
        return $this->belongsTo(Email::class);
    }
}

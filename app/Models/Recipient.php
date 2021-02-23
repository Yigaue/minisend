<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Recipient extends Model
{
    protected $fillable = ['email'];
    public function senders()
    {
        return $this->belongsToMany(User::class, 'sender_recipient', 'user_id');
    }

    public function emails()
    {
        return $this->belongsToMany(Email::class, 'sender_recipient');
    }
}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Recipient extends Model
{
    protected $fillable = ['email'];
    public function senders()
    {
        return $this->belongsToMany(User::class, 'sender_recipient', 'user_id');
    }
}

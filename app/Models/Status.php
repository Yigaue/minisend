<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use PhpParser\Node\Expr\PostDec;

class Status extends Model
{
    protected $table = 'status';

    const SENT = 1;
    const FAILED = 2;
    const POSTED = 3;
    const ACTIVE = 4;
    const DELETED = 5;
    const PENDING = 6;
}

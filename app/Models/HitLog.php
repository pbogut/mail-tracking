<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HitLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'message_id',
        'user_agent',
        'ip_address',
    ];
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ScheduledCall extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'admin_id',
        'agent_id',
        'title',
        'message',
        'link'
    ]


}

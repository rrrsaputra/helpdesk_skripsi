<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attachment_Call extends Model
{
    protected $table = 'attachment_calls';
    use HasFactory;
    protected $fillable = ['name', 'scheduled_call_id', 'path'];

    public function scheduled_call()
    {
        return $this->belongsTo(ScheduledCall::class);
    }
    
}



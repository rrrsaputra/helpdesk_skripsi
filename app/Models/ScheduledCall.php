<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ScheduledCall extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'assigned_from',
        'assigned_to',
        'title',
        'message',
        'link',
        'duration',
        'start_time',
        'finish_time'
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }


}

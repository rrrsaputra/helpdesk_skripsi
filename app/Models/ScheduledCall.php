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
        'finish_time',
        'references'
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }

    // public function assignedToUser()
    // {
    //     return $this->belongsTo(User::class, 'assigned_to');
    // }

    // public function assignedFromUser()
    // {
    //     return $this->belongsTo(User::class, 'assigned_from');
    // }

    public function attachments()
    {
        return $this->hasMany(Attachment_Call::class);
    }

    public function attachments_list()
    {
        return $this->attachments->map(function ($attachment) {
            return [
                'name' => $attachment->name,
                'path' => $attachment->path,
            ];
        });
    }

}

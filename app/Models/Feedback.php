<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Feedback extends Model
{
    use HasFactory;

    protected $fillable = [
        'subject',
        'message',
        // 'tags_id'
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function attachments()
    {
        return $this->hasMany(Attachment_Feedback::class);
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

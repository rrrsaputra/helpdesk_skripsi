<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attachment_Feedback extends Model
{
    protected $table = 'attachment_feedback';
    use HasFactory;
    protected $fillable = ['name', 'feedback_id', 'path'];

    public function feedback()
    {
        return $this->belongsTo(Feedback::class);
    }
}

<?php

namespace App\Models;

use Coderflex\LaravelTicket\Models\Ticket;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attachment extends Model
{
    use HasFactory;

    protected $fillable = ['name','message_id', 'path'];

    public function ticket()
    {
        return $this->belongsTo(Ticket::class);
    }
}
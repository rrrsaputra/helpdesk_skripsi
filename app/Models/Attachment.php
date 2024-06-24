<?php

namespace App\Models;

use Coderflex\LaravelTicket\Models\Ticket;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attachment extends Model
{
    use HasFactory;

    protected $fillable = ['ticket_id', 'path'];

    public function ticket()
    {
        return $this->belongsTo(Ticket::class);
    }
}
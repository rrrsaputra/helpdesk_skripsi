<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Trigger extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'query'];
// Start Generation Here
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Faq extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'content',
        'user_id',
        'faq_category_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function faqCategory()
    {
        return $this->belongsTo(FaqCategory::class);
    }
}

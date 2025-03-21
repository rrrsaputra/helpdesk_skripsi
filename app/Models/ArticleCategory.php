<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ArticleCategory extends Model
{
    use HasFactory;

    protected $fillable = [
        'category',
        'name',
        'slug'
    ];

    public function articles()
    {
        return $this->hasMany(Article::class);
    }
}
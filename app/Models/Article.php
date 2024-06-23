<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'content',
        'user_id',
        'article_category_id',
        // 'tags_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function articleCategory()
    {
        return $this->belongsTo(ArticleCategory::class, 'article_category_id');
    }
}

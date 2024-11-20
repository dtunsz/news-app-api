<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NewsapiArticle extends Model
{
    /** @use HasFactory<\Database\Factories\NewsapiArticleFactory> */
    use HasFactory;

    protected $fillable = [
        'keyword',
        'author',
        'title',
        'description',
        'web_url',
        'image_url',
        'content',
        'publication_date'
    ];

    public function scopeFilter($query, array $filters) {
        dd($filters);
    }
}

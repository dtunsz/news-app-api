<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GuardianArticle extends Model
{
    /** @use HasFactory<\Database\Factories\GuardianArticleFactory> */
    use HasFactory;

    protected $fillable = [
        'keyword',
        'origin_id',
        'type',
        'section_name',
        'title',
        'web_url',
        'api_url',
        'is_hosted',
        'pillar_name',
        'publication_date',
    ];
}

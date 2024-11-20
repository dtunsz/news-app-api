<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NytArticle extends Model
{
    /** @use HasFactory<\Database\Factories\NytArticleFactory> */
    use HasFactory;

    protected $fillable = [
        'keyword',
        'abstract',
        'web_url',
        'lead_paragraph',
        'uri',
        'section_name',
        'subsection_name',
        'publication_date',
    ];
}

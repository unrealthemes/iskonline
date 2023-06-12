<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Blog extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'h1',
        'link',
        'subtitle',
        'keywords',
        'description',
        'icon_class',
        'show_author_block',
        'show_form_block',
        'show_share_block',
        'preview',
        'text',
    ];
}

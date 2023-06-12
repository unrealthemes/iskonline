<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'client_json_file',
        'php_handler_file',
        'image',
        'service_category_id',
        'service_type_id',
        'price',
        'h1',
        'title',
        'link',
        'text',
        'videos',
        'meta',
        'rating',
        'preview_text'
    ];
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FormUiElement extends Model
{
    use HasFactory;

    protected $fillable = [
        "parent_table",
        "parent_id",
        "element_table",
        "element_id",
        "order",
        "column",
        "name",
        "options",
    ];
}

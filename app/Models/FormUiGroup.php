<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FormUiGroup extends Model
{
    use HasFactory;

    protected $fillable = [
        "name",
        "title",
        "options",
        "prefix",
        "clonable",
        "description",
        "show_in_saved"
    ];
}

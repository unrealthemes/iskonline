<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FormUiStep extends Model
{
    use HasFactory;

    protected $fillable = [
        "title",
        "options",
        "prefix",
        "show_in_saved"
    ];
}

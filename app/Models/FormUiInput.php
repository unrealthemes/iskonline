<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FormUiInput extends Model
{
    use HasFactory;

    protected $fillable = [
        "name",
        "label",
        "type",
        "events",
        "validation",
        "helper",
        "info",
        "options",
        "show_in_saved"
    ];
}

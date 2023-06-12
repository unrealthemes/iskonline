<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FormUiFormStep extends Model
{
    use HasFactory;

    protected $fillable = [
        "form_ui_form_id",
        "form_ui_step_id",
        'order'
    ];
}

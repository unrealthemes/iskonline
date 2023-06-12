<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FormsData extends Model
{
    use HasFactory;

    protected $fillable = [
        'data',
        'form_ui_form_id',
        'application_id',
    ];
}

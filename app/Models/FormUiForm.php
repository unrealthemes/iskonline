<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FormUIForm extends Model
{
    protected $table = 'form_ui_forms';
    use HasFactory;

    protected $fillable = [
        'name',
        'order',
        'service_id',
        'options',
    ];
}

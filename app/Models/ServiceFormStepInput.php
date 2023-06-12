<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServiceFormStepInput extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'label',
        'type',
        'suggestions',
        'visible',
        'required',
        'events_json',
        'attributes',
        'validation',
        'service_form_step_id'
    ];
}

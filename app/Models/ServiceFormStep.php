<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServiceFormStep extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'step_number',
        'fields_prefix',
        'next_step_id',
        'service_form_id'
    ];
}

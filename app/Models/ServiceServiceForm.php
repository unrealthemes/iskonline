<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServiceServiceForm extends Model
{
    use HasFactory;

    protected $fillable = [
        'service_id',
        'service_form_id',
        'order',
    ];
}

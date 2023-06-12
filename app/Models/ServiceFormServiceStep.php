<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServiceFormServiceStep extends Model
{
    use HasFactory;

    protected $fillable = [
        'service_form_id',
        'service_form_step_id'
    ];
}

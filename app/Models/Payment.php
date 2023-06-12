<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'service_type',
        'service_id',
        'application_id',
        'amount',
        'order_number',
        'order_id',
        'status',
        'form_url',
    ];
}

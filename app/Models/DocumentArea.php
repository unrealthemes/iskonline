<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DocumentArea extends Model
{
    use HasFactory;

    protected $fillable = [
        'areas',
        'service_id',
        'name'
    ];
}

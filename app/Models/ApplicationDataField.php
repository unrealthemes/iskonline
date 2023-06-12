<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ApplicationDataField extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'value',
        'application_id',
        'created_at'
    ];
}

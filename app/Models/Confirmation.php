<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;

class Confirmation extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'table',
        'target_id',
        'active',
        'confirmation_type',
        'active_by',
        'action_data',
        'action'
    ];

    public function setCodeAttribute($value)
    {
        $this->attributes['code'] = Hash::make($value);
    }
}

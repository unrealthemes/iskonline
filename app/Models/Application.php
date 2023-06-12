<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Application extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'service_id',
        'application_status_id',
        'confirmed',
        'payed',
        'edited',
    ];

    public function nextStatus()
    {
        $next = ApplicationStatus::find($this->application_status_id)->next_application_status_id;
        $this->application_status_id = $next ? $next : $this->application_status_id;
        $this->save();
    }
}

<?php

namespace App\Querys\Services;

use App\Models\Service;

class GetService
{

    public static function find(int $id)
    {
        return Service::query()->findOrFail($id);
    }
}

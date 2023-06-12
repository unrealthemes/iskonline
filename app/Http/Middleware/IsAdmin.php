<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\App;

class ISAdmin
{

    public function handle($request, Closure $next)
    {
        if ($request->user()->status != 0) {
            return redirect()->to(route('login'));
        }

        return $next($request);
    }
}

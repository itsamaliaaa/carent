<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class IsAdminRental
{
    public function handle(Request $request, Closure $next)
    {
        if (!auth()->check() || !auth()->user()->isAdminRental()) {
            abort(403, 'Akses ditolak.');
        }
        return $next($request);
    }
}
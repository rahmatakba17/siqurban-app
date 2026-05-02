<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class PanitiaMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if (auth()->check() && in_array(auth()->user()->role, ['panitia', 'admin'])) {
            return $next($request);
        }

        if ($request->expectsJson()) {
            return response()->json(['message' => 'Akses ditolak.'], 403);
        }

        return redirect('/')->with('error', 'Akses ditolak.');
    }
}

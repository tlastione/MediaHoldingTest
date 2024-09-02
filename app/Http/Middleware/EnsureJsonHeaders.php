<?php

namespace App\Http\Middleware;

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class EnsureJsonHeaders
{
    public function handle(Request $request, Closure $next)
    {
        if (!$request->expectsJson()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Missing or invalid Accept header. Expected "application/json".'
            ], 406); 
        }

        if ($request->header('Content-Type') !== 'application/json') {
            return response()->json([
                'status' => 'error',
                'message' => 'Missing or invalid Content-Type header. Expected "application/json".'
            ], 415); 
        }

        return $next($request);
    }
}


<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class JsonMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        return response()->json(['sadf']);
        // return response()->json($next($request)->content());
    }
}

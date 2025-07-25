<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class isAdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!auth()->check() || (auth()->user()->role != 'admin')) { 	//check di autnetificazione fatta (controllo in più)
            return response()->view('errors.wrongID', ['message' => 'Only admin can access!'], 403);
        }
        return $next($request);
    }
}

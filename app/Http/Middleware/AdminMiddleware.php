<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Log;



class AdminMiddleware

{
    
    public function handle(Request $request, Closure $next)
{
    Log::info('AdminMiddleware - Is user logged in: ' . (Auth::check() ? 'Yes' : 'No'));
    if (Auth::check()) {
        Log::info('AdminMiddleware - User role: ' . Auth::user()->role);
        Log::info('AdminMiddleware - Is user admin: ' . (Auth::user()->isAdmin() ? 'Yes' : 'No'));
    }

    if (Auth::check() && Auth::user()->isAdmin()) {
        return $next($request);
    }

    return redirect()->route('login')->with('error', 'Unauthorized access.');
}

}

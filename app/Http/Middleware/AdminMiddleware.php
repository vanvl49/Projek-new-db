<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        // Periksa apakah pengguna masuk sebagai admin
        if (Auth::guard('admin')->check()) {
            return $next($request);
        }

        // Redirect jika bukan admin
        return redirect()->route('admin.login')->withErrors(['unauthorized' => 'Access denied. Admins only.']);
    }
}


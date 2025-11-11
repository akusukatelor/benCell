<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class RoleRedirect
{
    public function handle(Request $request, Closure $next)
    {
        $user = auth()->user();

        if (!$user) {
            return redirect('/login');
        }

        if ($user->hasRole('admin')) {
            return redirect('/dashboard');
        }

        if ($user->hasRole('karyawan')) {
            return redirect('/home');
        }

        return $next($request);
    }
}
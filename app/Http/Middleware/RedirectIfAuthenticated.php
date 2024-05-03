<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
{
    public function handle(Request $request, Closure $next, $guard = null)
    {
        if (Auth::guard($guard)->check()) {
            // Si el usuario está autenticado, redirige a la ruta '/consulta-y-registro'
            return redirect('/consulta');
        }

        return $next($request);
    }
}

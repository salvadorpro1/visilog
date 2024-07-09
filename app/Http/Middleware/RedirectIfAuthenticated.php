<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        if (Auth::guard($guard)->check()) {
            $user = Auth::user();

            if ($user->role == 'administrador') {
                return redirect('/dashboard');
            } elseif ($user->role == 'operador') {
                return redirect('/consulta');
            } else {
                // Otras redirecciones basadas en diferentes roles
                return redirect('/home'); // O una ruta por defecto
            }
        }

        return $next($request);
    }
}

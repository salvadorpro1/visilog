<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string  $role
     * @return mixed
     */
    public function handle($request, Closure $next, $role)
    {
        $user = Auth::user();

        if ($user->role !== $role) {
            if ($role == 'operador') {
                // Redirige a los operadores a la ruta 'show_consult'
                return redirect()->route('show_Dashboard');

            } else {
                // Redirige a los administradores a la ruta 'show_Dashboard'
                return redirect()->route('show_consult');
            }
        }

        return $next($request);
    }
}

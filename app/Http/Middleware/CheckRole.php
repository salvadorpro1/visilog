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
public function handle($request, Closure $next, ...$roles)
    {
        $user = Auth::user();

        if (! $user) {
            // Si no está autenticado, lo mandas a login o donde quieras
            return redirect()->route('login');
        }

        // Si el rol del usuario NO está en la lista de roles permitidos
        if (! in_array($user->role, $roles)) {
            // Puedes hacer lógica de redirección basada en rol del usuario
            // Por ejemplo:
            if ($user->role === 'administrador') {
                return redirect()->route('show_Dashboard');
            } elseif ($user->role === 'operador') {
                return redirect()->route('show_consult');
            } else {
                // Para otros roles que no están permitidos
                abort(403, 'No autorizado');
            }
        }

        return $next($request);
    }

}

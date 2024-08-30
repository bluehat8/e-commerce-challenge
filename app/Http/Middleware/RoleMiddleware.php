<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, $role)
    {
        if (!auth()->check()) {
            // Si el usuario no está autenticado
            abort(403, 'Acceso no autorizado.');
        }

        if (auth()->user()->role !== $role) {
            // Si el usuario no tiene el rol requerido
            abort(403, 'Acceso no autorizado.');
        }

        return $next($request);
    }
}

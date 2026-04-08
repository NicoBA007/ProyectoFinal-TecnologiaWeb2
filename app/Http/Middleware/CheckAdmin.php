<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckAdmin
{
    public function handle(Request $request, Closure $next): Response
    {
        // Usamos Auth:: en lugar del helper auth() para que el editor no se queje
        if (Auth::check() && Auth::user()->rol === 'admin') {
            return $next($request);
        }

        return redirect('/')->with('error', 'Acceso denegado. Se requieren permisos de administrador.');
    }
}

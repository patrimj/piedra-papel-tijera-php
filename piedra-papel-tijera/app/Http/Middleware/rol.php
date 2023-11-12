<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;


class Rol{ // inicio de sesión para que solo los usuarios registrados puedan acceder a las rutas y solo los administradores puedan acceder a las rutas de administrador
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response { 

        $user = $request->user(); // recogemos el usuario autenticado

        if ($user && $user->tokenCan('admin')) { // comprobamos que el usuario está autenticado y que su token tiene el permiso 'admin'
            return $next($request); 
        } else {
            return response()->json(['error' => 'No tienes permisos para acceder a esta ruta'], 403); 
        }
    }
}

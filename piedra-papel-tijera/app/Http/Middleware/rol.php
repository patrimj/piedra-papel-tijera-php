<?php

namespace App\Http\Middleware;

use App\Http\Middleware\inicio;
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

        $usuarioAutenticado = new Inicio();
        $usuarioAutenticado = $usuarioAutenticado->handle($request, $next); // comprobamos que el usuario está autenticado

        if ($usuarioAutenticado->getStatusCode() == 200) { // si el usuario está autenticado
            $usuario = $request->user(); // recogemos el usuario autenticado --> user() es un método de la clase Request que devuelve el usuario autenticado
            if ($usuario->rol == 1) { 
                return $next($request); 
            } else {
                return response()->json(['error' => 'No tienes permisos para acceder a esta ruta'], 403); 
            }
        } else {
            return $usuarioAutenticado; // devolvemos el error de inicio
        }
    }
}

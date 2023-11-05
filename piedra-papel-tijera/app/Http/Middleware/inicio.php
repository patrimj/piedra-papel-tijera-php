<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;


class inicio
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response{
        $usuario_id = $request->get('id');

        if ($usuario_id) { // tanto administradores como usuarios registrados pueden acceder a las rutas de inicio
            return $next($request);
        }else{
            return response()->json(['error' => 'No tienes permisos para acceder a esta ruta'], 403);
        }
    } 
}
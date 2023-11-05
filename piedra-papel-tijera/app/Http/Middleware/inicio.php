<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

use App\Models\Usuario;


class Inicio
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response{

        $datosUsuario = $request->all(); // recogemos los datos del usuario, del usuario porque es el que se ha logueado
        $email = $datosUsuario['email'];
        $password = $datosUsuario['password'];

        $usuario = Usuario::where('email', $email)->where ('password', $password)->first(); // buscamos el usuario en la base de datos

        if ($usuario) { 
            return $next($request); // dejamos pasar al usuario
        } else {
            return response()->json(['error' => 'No tienes permisos para acceder a esta ruta'], 403); 
        }
    } 
}
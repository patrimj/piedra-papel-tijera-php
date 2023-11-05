<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class rol{ // inicio de sesión para que solo los usuarios registrados puedan acceder a las rutas y solo los administradores puedan acceder a las rutas de administrador
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response { 
        if (Auth::check() && Auth::user()->rol == 1) {
            return $next($request);
        } else {
            return response()->json(['error' => 'No tienes permisos para acceder a esta ruta'], 403);
        }
    } 
/*
        //Middleware login.
        $pers = Persona::where('email',$request->get('email'))
                        ->where('password',Hash::make($request->get('pass')))
                        ->first();
        if ($pers){
            if ($pers->getRol()==1){
                return $next($request);
            }
            else {
                return response->json('No puedes pasar por mindundi',204);
            }
        }
        else {
            return response->json('No puedes pasar por login',204);
        }
*/
}

<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EncryptPassword
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if ($request->has('password')) { // si el request tiene el campo password
            $password = $request->get('password'); // lo pilla
            $encryptedPassword = bcrypt($password); // lo encripta
            $request->merge(['password' => $encryptedPassword]); // y lo vuelve a meter en el request
        }

        return $next($request);
    }
}

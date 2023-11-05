<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\Partida;


class VerificarPartida
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle($request, Closure $next)
    {
        $partida = Partida::where('usuario_id', $request->user()->id)
            ->where('ganadas_usuario', '<', 3)
            ->where('ganadas_maquina', '<', 3)
            ->first();

        if ($partida) {
            return response()->json(['message' => 'Ya tienes una partida en curso'], 403);
        }

        return $next($request);
    }
}

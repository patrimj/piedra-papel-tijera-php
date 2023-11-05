<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PartidaController extends Controller{

    public function crearPartida(Request $request){ // solo se encarga de crear una partida, si ya tiene una abierta saltara error y ya. si quiere unirse a una ya abierta deberá llamar a la funcion jugar() 

        try{
            $usuario_id = $request->get('usuario_id');// en el bdy

            $partida_abierta = DB::table('partidas')//se busca si el usuario tiene una partida abierta
                ->where('usuario_id', $usuario_id)
                ->where('finalizada', 0) 
                ->first();

            if ($partida_abierta) {
                return response()->json(['error' => 'Ya tienes una partida abierta'], 400);

            }else{
                $partida_id = DB::table('partidas')->insertGetId([ // insertGetId() devuelve el ID de la partida creada
                    'usuario_id' => $usuario_id,
                    'finalizada' => 0 
                ]);

                return response()->json(['partida_id' => $partida_id]);
            }
                
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error al crear la partida'], 500);
        }
    }

    public function obtenerResultado(Request $request){

        try{
            $partida_id = $request->get('id'); 

            // se bysca la partida en la base de datos
            $partida = DB::table('partidas')->where('id', $partida_id)->first();

            if (!$partida) {
                return response()->json(['error' => 'La partida no existe'], 404);

            } else if ($partida->finalizada == 0) {
                return response()->json(['mensaje' => 'La partida aún está abierta'], 200);

            } else {
                $resultado = $partida->resultado; 
                return response()->json(['resultado' => $resultado], 200);
            }

        } catch (\Exception $e) {
            return response()->json(['error' => 'Error al obtener el resultado de la partida'], 500);
        }
    }

    public function eliminarPartida (Request $request){

        try{
            $partida_id = $request->get('id'); 

            // se busca la partida en la base de datos
            $partida = DB::table('partidas')->where('id', $partida_id)->first();

            if (!$partida) {
                return response()->json(['error' => 'La partida no existe'], 404);

            } else if ($partida->finalizada == 0) {
                return response()->json(['mensaje' => 'La partida aún está abierta'], 200);
            } else {
                
                DB::table('partidas')->where('id', $partida_id)->delete();
                return response()->json(['mensaje' => 'Partida eliminada'], 200);
            }

        } catch (\Exception $e) {
            return response()->json(['error' => 'Error al eliminar la partida'], 500);
        }
    }

    public function jugar(Request $request){ // en el post se tendra que poner usuario_id, id(id de la partida), jugador1_id, tirada_jugador1
        
        try {
            $usuario_id = $request->get('usuario_id');
            $partida_id = $request->get('id'); 
    
            if ($partida_id) { // se une a una partida existente
                $partida = DB::table('partidas')->where('id', $partida_id)->first();

                if (!$partida) {
                    return response()->json(['error' => 'La partida no existe']);

                }else if ($partida->finalizada == 1) {
                    return response()->json(['error' => 'La partida ya ha terminado']);
                }

            } else {// Crear una nueva partida
                $partida_id = DB::table('partidas')->insertGetId([
                    'usuario_id' => $usuario_id,
                    'finalizada' => 0
                ]);
            }

            // se hace la jugada
            $tiradaController = new TiradaController();
            $resultado = $tiradaController->realizarTirada($request);
            return $resultado;

        } catch (\Exception $e) {
            return response()->json(['error' => 'Error al realizar la jugada'], 500);
        } 
    }

    public function ranking(){// ranking de jugadores con más partidas ganadas
        
        try {
            $jugadores = DB::table('usuarios')
                ->select('id', 'nombre', 'partidas_ganadas')
                ->orderByDesc('partidas_ganadas') // orderByDesc() ordena los resultados de forma descendente
                ->get();

            $resultados = []; // array con los resultados

            foreach ($jugadores as $jugador) {
                $nombre_jugador = $jugador->nombre;
                $partidas_ganadas = $jugador->partidas_ganadas;
                
                $resultados[] = [
                    'jugador' => $nombre_jugador,
                    'partidas_ganadas' => $partidas_ganadas
                ];
            }

            return response()->json(['resultados' => $resultados], 200);

        } catch (\Exception $e) {
            return response()->json(['error' => 'Error al obtener el ranking'], 500);
        }
    }
}

    

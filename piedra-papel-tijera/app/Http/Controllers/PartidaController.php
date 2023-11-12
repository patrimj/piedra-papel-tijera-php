<?php

namespace App\Http\Controllers;

use App\Models\Partida;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Models\Usuario;

class PartidaController extends Controller{

//FUNCIONES PARTIDA - LISTAR, CREAR, OBTENER POR ID, ELIMINAR, FINALIZAR, JUGAR, OBTENER RESULTADO, RANKING

    public function listaPartidas(){  // todas las partidas
        try {
            $partidas = Partida::all();
            return response()->json($partidas,200);

        } catch (\Exception $e) {
            return response()->json(['error' => 'Error al obtener la lista de partidas'], 500);
        }
    }

    public function partidaID(Request $request){ // partida por id

        try{
            $id = $request->get('id');

            $partida = Partida::find($id);

            if (!$partida) {
                return response()->json(['error' => 'La partida no existe'], 404);
            }else{
                return response()->json($partida,200);
            }
       

        } catch (\Exception $e) {
            return response()->json(['error' => 'Error al obtener la partida'], 500);
        }    

    }

    public function crearPartida(Request $request){ // solo se encarga de crear una partida, si ya tiene una abierta saltara error y ya. si quiere unirse a una ya abierta deberá llamar a la funcion jugar() 

        try{
            $usuario_id = $request->get('usuario_id');// en el bdy

            $partida_abierta = Partida::where('usuario_id', $usuario_id) // buscar partida abierta
            ->where('finalizada', 0) 
            ->first();

            if ($partida_abierta) {
                return response()->json(['error' => 'Ya tienes una partida abierta'], 400);

            }else{
                $partida = new Partida();
                $partida->usuario_id = $usuario_id;
                $partida->finalizada = 0;
                $partida->save();

                return response()->json(['Partida' => $partida]);
            }
                
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error al crear la partida'], 500);
        }
    }

    public function obtenerResultado(Request $request){

        try{
            $partida_id = $request->get('id'); 

            // se bysca la partida en la base de datos
            $partida = Partida::find($partida_id); // con Eloquent
            //$partida = DB::table('partidas')->where('id', $partida_id)->first(); // con Query Builder

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
            //$partida = DB::table('partidas')->where('id', $partida_id)->first(); // con Query Builder
            $partida = Partida::find($partida_id); // con Eloquent

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

    public function finalizarPartida (Request $request ){
            
            try{
                $partida_id = $request->get('id'); 
    
                // se busca la partida en la base de datos
                $partida = Partida::find($partida_id);
    
                if (!$partida) {
                    return response()->json(['error' => 'La partida no existe'], 404);
    
                } else if ($partida->finalizada == 1) {
                    return response()->json(['mensaje' => 'La partida ya ha terminado'], 200);
    
                } else {
                    $partida->finalizada = 1; // con Eloquent
                    $partida->save();
                    return response()->json(['mensaje' => 'Partida finalizada'], 200);
                    //DB::table('partidas')->where('id', $partida_id)->update(['finalizada' => 1]); // con Query Builder
                    //return response()->json(['mensaje' => 'Partida finalizada'], 200);
                }
    
            } catch (\Exception $e) {
                return response()->json(['error' => 'Error al finalizar la partida'], 500);
            }
    }

    public function jugar(Request $request){ // en el post se tendra que poner usuario_id, id(id de la partida), jugador1_id, tirada_jugador1
        
        try {
            $usuario_id = $request->get('usuario_id');
            $partida_id = $request->get('id'); 
    
            if ($partida_id) { // se une a una partida existente
                $partida = Partida::find($partida_id); // con Eloquent 
                //$partida = DB::table('partidas')->where('id', $partida_id)->first(); // con Query Builder

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

            $jugadores = Usuario::select('id', 'nombre', 'partidas_ganadas') // con Eloquent
            ->orderByDesc('partidas_ganadas')
            ->get();

            /*
            $jugadores = DB::table('usuarios') // Query Builder
                ->select('id', 'nombre', 'partidas_ganadas')
                ->orderByDesc('partidas_ganadas') // orderByDesc() ordena los resultados de forma descendente
                ->get();*/

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

    

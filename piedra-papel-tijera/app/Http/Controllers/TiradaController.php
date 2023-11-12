<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Models\Usuario;
use App\Models\Partida;
use App\Models\Tirada;

class TiradaController extends Controller{

    public function listaTiradas(){  // todas las tiradas 
        try {

            $tiradas =  Tirada::all();
            return response()->json($tiradas,200);

        }catch (\Exception $e) {
            return response()->json(['error' => 'Error al obtener la lista de tiradas'], 500);
        }
    }   

    public function tiradaID(Request $request){ // tirada por id

        try{
            $id = $request->get('id');

            $tirada = Tirada::find($id);

            if (!$tirada) {
                return response()->json(['error' => 'La tirada no existe'], 404);
            }else{
                return response()->json($tirada,200);
            }
       

        } catch (\Exception $e) {
            return response()->json(['error' => 'Error al obtener la tirada'], 500);
        }    

    }

    public function realizarTirada(Request $request){

        try {
            $partida_id = $request->get('partida_id');
            $jugador1_id = $request->get('jugador1_id');
            $tirada_jugador1 = $request->get('tirada_jugador1');
            $tirada_jugador2 = $this->generarTiradaMaquina(); 

            // Compara las tiradas y sacar el resultado
            $resultado = $this->calcularResultado($tirada_jugador1, $tirada_jugador2);

            // insertar la tirada en la base de datos
            $tirada = new Tirada();
            $tirada->partida_id = $partida_id;
            $tirada->jugador1_id = $jugador1_id;
            $tirada->tirada_jugador1 = $tirada_jugador1;
            $tirada->tirada_jugador2 = $tirada_jugador2;
            $tirada->resultado = $resultado;
            $tirada->save();
            
            // cuantas tiradas ha ganado el usuario
            $jugadas_ganadas_usuario = Tirada::where('jugador1_id', $jugador1_id)
                ->where('partida_id', $partida_id)
                ->where('resultado', 'ganada')
                ->count();

            if ($jugadas_ganadas_usuario >= 3) { // El usuario ha ganado la partida
                
                //DB::table('partidas')->where('id', $partida_id)->update(['finalizada' => 1]); //con Query Builder
                
                //con eloquent
                $partida = Partida::find($partida_id);
                $partida->finalizada = 1;
                $partida->resultado = 'ganada';
                $partida->save();

                //$resultado = 'ganada';

                $this->actualizarPartidasGanadas($jugador1_id);
                $this->actualizarPartidasJugadas($jugador1_id);

            } else {// El ordenador ha ganado la partida

                //DB::table('partidas')->where('id', $partida_id)->update(['finalizada' => 1]); //con Query Builder
                //$resultado = 'perdida';
                
                //con eloquent
                $partida = Partida::find($partida_id);
                $partida->finalizada = 1;
                $partida->resultado = 'perdida';
                $partida->save();

                $this->actualizarPartidasJugadas($jugador1_id);
            }

            return response()->json(['resultado' => $resultado, 'tirada_jugador1' => $tirada_jugador1, 'tirada_jugador2' => $tirada_jugador2]);
        
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error al realizar la tirada'], 500);
        }
    }

    private function generarTiradaMaquina()
    {
        $tiradas = ['piedra', 'papel', 'tijera'];
        $tirada_aleatoria = array_rand($tiradas, 1);

        return $tiradas[$tirada_aleatoria];
    }

    public function calcularResultado($tirada_jugador1, $tirada_jugador2)
    {
        if ($tirada_jugador1 === $tirada_jugador2) {
            return 'empate';
        } elseif (
            ($tirada_jugador1 === 'piedra' && $tirada_jugador2 === 'tijera') ||
            ($tirada_jugador1 === 'papel' && $tirada_jugador2 === 'piedra') ||
            ($tirada_jugador1 === 'tijera' && $tirada_jugador2 === 'papel')
        ) {
            return 'ganada';
        } else {
            return 'perdida';
        }
    }

    function actualizarPartidasGanadas($usuario_id) {
        $usuario = Usuario::find($usuario_id);
        if ($usuario) {
            $usuario->increment('partidas_ganadas');
        }
    }

    function actualizarPartidasJugadas($usuario_id) {
        $usuario = Usuario::find($usuario_id);
        if ($usuario) {
            $usuario->increment('partidas_jugadas');
        }
    }

}

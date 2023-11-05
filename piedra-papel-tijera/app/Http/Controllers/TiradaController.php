<?php

namespace App\Http\Controllers;

use App\Models\Tirada;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
            DB::table('tiradas')->insert([
                'partida_id' => $partida_id,
                'jugador1_id' => $jugador1_id,
                'tirada_jugador1' => $tirada_jugador1,
                'tirada_jugador2' => $tirada_jugador2,
                'resultado' => $resultado,
            ]);

            // cuantas tiradas ha ganado el usuario
            $jugadas_ganadas_usuario = DB::table('tiradas')
                ->where('jugador1_id', $jugador1_id)
                ->where('partida_id', $partida_id)
                ->where('resultado', 'ganada')
                ->count();

            if ($jugadas_ganadas_usuario >= 3) { // El usuario ha ganado la partida
                
                DB::table('partidas')->where('id', $partida_id)->update(['finalizada' => 1]);
                $resultado = 'ganada';

                $this->actualizarPartidasGanadas($jugador1_id);
                $this->actualizarPartidasJugadas($jugador1_id);

            } else {// El ordenador ha ganado la partida

                DB::table('partidas')->where('id', $partida_id)->update(['finalizada' => 1]);
                $resultado = 'perdida';

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

    private function calcularResultado($tirada_jugador1, $tirada_jugador2)
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
        DB::table('usuarios')
            ->where('id', $usuario_id)
            ->increment('partidas_ganadas');
    }

    function actualizarPartidasJugadas($usuario_id) {
        DB::table('usuarios')
            ->where('id', $usuario_id)
            ->increment('partidas_jugadas');
    }

}

<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use \App\Models\Partida;
use \App\Models\Usuario;
use \App\Http\Controllers\TiradaController;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Tirada>
 */
class TiradaFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $tirada_jugador1 = $this->faker->randomElement(['piedra', 'papel', 'tijera']);
        $tirada_jugador2 = $this->faker->randomElement(['piedra', 'papel', 'tijera']);
    
        $tirada = new TiradaController;
        $resultado = $tirada->calcularResultado($tirada_jugador1, $tirada_jugador2);
    
        return [
            'partida_id' => Partida::factory(),
            'usuario_id' => Usuario::factory(),
            'tirada_jugador1' => $tirada_jugador1,
            'tirada_jugador2' => $tirada_jugador2,
            'resultado' => $resultado,
        ];
    }
}

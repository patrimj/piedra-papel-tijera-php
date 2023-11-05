<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

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
        return [
            'partida_id' => \App\Models\Partida::factory(),
            'usuario_id' => \App\Models\Usuario::factory(),
            'tirada_jugador1' => $this->faker->randomElement(['piedra', 'papel', 'tijera']),
            'tirada_jugador2' => $this->faker->randomElement(['piedra', 'papel', 'tijera']),
            'resultado' => $this->faker->randomElement(['ganada', 'perdida']),
        ];
    }
}

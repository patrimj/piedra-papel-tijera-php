<?php

namespace Database\Factories;

use App\Models\Tirada;
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
    protected $model = Tirada::class;
    public function definition(): array
    {
        return [
            'partida_id' => $this->faker->numberBetween(1, 100),
            'jugador1_id' => $this->faker->numberBetween(1, 100),
            'tirada_jugador1' => $this->faker->randomElement(['Piedra','Papel','Tijera' ]),
            'tirada_jugador2' => $this->faker->randomElement(['Piedra','Papel','Tijera' ]),
            'resultado' => $this->faker->randomElement(['Ganada','Perdida' ]),
        ];
    }

}

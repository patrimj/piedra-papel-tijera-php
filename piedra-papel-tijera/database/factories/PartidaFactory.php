<?php

namespace Database\Factories;

use App\Models\Partida;
use App\Models\Tirada;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Partida>
 */
class PartidaFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = Partida::class;
    public function definition(): array
    {
        return [
            'usuario_id' => $this->faker->numberBetween(1, 100),
            'finalizada' => $this->faker->boolean(),
            'resultado' => $this->faker->randomElement(['Ganada','Perdida' ]),
        ];
    }

    public function configure()
    {
        return $this->afterCreating(function ($partida  ) {
            $numeroTiradas = rand(0,5); // Cambia esto al número deseado de partidas por usuario.
            Tirada::factory($numeroTiradas)->create(['partida_id' => $partida->id]);

        });
    }
}

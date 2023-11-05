<?php

namespace Database\Factories;

use App\Models\Partida;
use Illuminate\Database\Eloquent\Factories\Factory;




/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Usuario>
 */
class UsuarioFactory extends Factory
{
    /**
     * Define the model's default state.
     * @var string
     * @return array<string, mixed>
     */

     protected $model = Usuario::class;
    public function definition(): array
    {
        return [
            'id' => $this->faker->unique()->numberBetween(1, 100),
            'nombre' => $this->faker->name(),
            'contraseña' => $this->faker->password(),
            'partidas_jugadas' => $this->faker->numberBetween(0, 100),
            'partidas_ganadas' => $this->faker->numberBetween(0, 100),
            'rol' => $this->faker->boolean()
            
        ];
    }

    public function configure()
    {
        return $this->afterCreating(function ($usuario ) {
            $numeroPartidas = rand(0,5); // Cambia esto al número deseado de partidas por usuario.
            Partida::factory($numeroPartidas)->create(['usuario_id' => $usuario->id]);
        });
    }
}

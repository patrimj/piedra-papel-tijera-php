<?php

namespace Database\Factories;

use App\Models\Usuario;
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
        $usuario = Usuario::factory()->create(); // asi creamos un usuario con el factory de usuario

        return [
            'usuario_id' => $usuario->id, // y ese usuario lo usamos para crear una partida, asi no habra partida sin usuario
            'finalizada' => $this->faker->boolean,
            'resultado' => $this->faker->randomElement(['ganada', 'perdida']),
        ];
    } 


    public function configure()
    {
        
    }
}

<?php

namespace Database\Factories;

use App\Models\Usuario;
use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Partida;
/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Partida>
 */
class PartidaFactory extends Factory
{
    protected $model = Partida::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */

    

    public function definition(): array
    {
        $usuario = Usuario::factory()->create(); // asi creamos un usuario con el factory de usuario
        $finalizada = $this->faker->boolean;

        return [
            'usuario_id' => $usuario->id, // y ese usuario lo usamos para crear una partida, asi no habra partida sin usuario
            'finalizada' => $finalizada,// si no ha finalizado la partida, el resultado sera null
            'resultado' => $finalizada ? $this->faker->randomElement(['ganada', 'perdida', 'empate']) : null,
        ];
    } 

}

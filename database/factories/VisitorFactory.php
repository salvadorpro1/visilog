<?php

namespace Database\Factories;

use App\Models\Visitor;
use Illuminate\Database\Eloquent\Factories\Factory;

class VisitorFactory extends Factory
{
    protected $model = Visitor::class;

    public function definition()
    {
        return [
            'user_id' => 2,  // Valor fijo para user_id
            'nombre' => $this->faker->firstName,
            'apellido' => $this->faker->lastName,
            'nacionalidad' => $this->faker->randomElement(['V', 'E']),
            'cedula' => $this->faker->unique()->numberBetween(10000000, 99999999),
            'filial_id' => $this->faker->numberBetween(1, 2), // Ajustado para ser un id de filial
            'gerencia_id' => $this->faker->numberBetween(1, 4), // Ajustado para ser un id de gerencia
            'razon_visita' => $this->faker->sentence,
            'foto' => $this->faker->imageUrl(), // Generar una URL de imagen de ejemplo
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}

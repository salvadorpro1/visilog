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
            'filial' => $this->faker->company,
            'gerencia' => $this->faker->word,
            'razon_visita' => $this->faker->sentence,
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}

<?php

namespace Database\Factories;

use App\Models\Visitor;
use Illuminate\Database\Eloquent\Factories\Factory;

class VisitorFactory extends Factory
{
    protected $model = Visitor::class;

    public function definition()
    {

         // Generar un filial_id aleatorio (1 o 2)
    $filial_id = $this->faker->numberBetween(1, 2);

    // Definir el rango de gerencias en función del filial_id
    $gerencia_id = $filial_id === 1
        ? $this->faker->numberBetween(1, 2) // Si filial_id es 1, gerencia_id será 1 o 2
        : $this->faker->numberBetween(3, 4); // Si filial_id es 2, gerencia_id será 3 o 4
        
        return [
            'user_id' => 1,  // Valor fijo para user_id
            'nombre' => $this->faker->firstName,
            'apellido' => $this->faker->lastName,
            'nacionalidad' => $this->faker->randomElement(['V', 'E']),
            'cedula' => $this->faker->unique()->numberBetween(10000000, 99999999),
            'filial_id' => $filial_id, // El filial_id generado aleatoriamente
            'gerencia_id' => $gerencia_id, // Gerencia dependiente de filial_id
            'razon_visita' => $this->faker->sentence,
            'foto' => $this->faker->imageUrl(), // Generar una URL de imagen de ejemplo
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}

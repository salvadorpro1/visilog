<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB; // Asegúrate de importar esta clase

class GerenciaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('gerencias')->insert([
            ['nombre' => 'Gerencia 1', 'filial_id' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['nombre' => 'Gerencia 2', 'filial_id' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['nombre' => 'Gerencia 3', 'filial_id' => 2, 'created_at' => now(), 'updated_at' => now()],
            ['nombre' => 'Gerencia 4', 'filial_id' => 2, 'created_at' => now(), 'updated_at' => now()],
            // Agrega más filas si es necesario
        ]);    
    }
}
//php artisan db:seed --class=GerenciaSeeder
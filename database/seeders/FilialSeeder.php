<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB; // Asegúrate de importar esta clase

class FilialSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('filiales')->insert([
            ['nombre' => 'Filial 1', 'created_at' => now(), 'updated_at' => now()],
            ['nombre' => 'Filial 2', 'created_at' => now(), 'updated_at' => now()],
            // Agrega más filas si es necesario
        ]);    }
}
//php artisan db:seed --class=FilialSeeder
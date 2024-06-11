<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class VisitorsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('visitors')->insert([
            'user_id' => 2, // Asegúrate de que este ID existe en la tabla users
            'nombre' => 'Juan',
            'apellido' => 'Pérez',
            'nacionalidad' => 'V',
            'cedula' => '28012171',
            'filial' => 'Vencemos',
            'gerencia' => 'value1A',
            'razon_visita' => 'Reunión de negocios',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('visitors')->insert([
            'user_id' => 2, // Asegúrate de que este ID existe en la tabla users
            'nombre' => 'María',
            'apellido' => 'González',
            'nacionalidad' => 'E',
            'cedula' => '13576096',
            'filial' => 'Vencemos',
            'gerencia' => 'value1A',
            'razon_visita' => 'Entrega de documentación',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}

//php artisan db:seed --class=VisitorsTableSeeder

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
            'nombre' => 'Juan',
            'apellido' => 'Pérez',
            'cedula' => '28012171',
            'filial' => 'Filial 1',
            'gerencia' => 'Gerencia A',
            'razon_visita' => 'Reunión de negocios',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('visitors')->insert([
            'nombre' => 'María',
            'apellido' => 'González',
            'cedula' => '13576096',
            'filial' => 'Filial 2',
            'gerencia' => 'Gerencia B',
            'razon_visita' => 'Entrega de documentación',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}

//php artisan db:seed --class=VisitorsTableSeeder

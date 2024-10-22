<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        DB::table('users')->insert([
            'name' => 'Usuario',
            'username' => 'usuario',
            'password' => Hash::make('contraseña'),
            'role' => 'administrador',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // DB::table('users')->insert([
        //     'name' => 'Usuario2',
        //     'username' => 'usuario2',
        //     'password' => Hash::make('contraseña'),
        //     'role' => 'operador',
        //     'created_at' => now(),
        //     'updated_at' => now(),
        // ]);
    }
}

//php artisan db:seed --class=UsersTableSeeder

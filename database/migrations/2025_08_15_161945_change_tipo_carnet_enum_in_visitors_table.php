<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
 public function up(): void
    {
        // Primero modificamos el ENUM para aceptar 'ficha'
        DB::statement("ALTER TABLE visitors MODIFY COLUMN tipo_carnet ENUM('visitante', 'trabajador', 'ficha') NULL");

        // Después actualizamos los datos existentes
        DB::table('visitors')
            ->where('tipo_carnet', 'trabajador')
            ->update(['tipo_carnet' => 'ficha']);
    }

    public function down(): void
    {
        // Revertir los cambios: poner 'ficha' como 'trabajador'
        DB::table('visitors')
            ->where('tipo_carnet', 'ficha')
            ->update(['tipo_carnet' => 'trabajador']);

        // Volver al ENUM original
        DB::statement("ALTER TABLE visitors MODIFY COLUMN tipo_carnet ENUM('visitante', 'trabajador') NULL");
    }
};
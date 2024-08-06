<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('visitors', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->string('nombre');
            $table->string('apellido');
            $table->enum('nacionalidad', ['V', 'E']);
            $table->string('cedula');
            $table->unsignedBigInteger('filial_id');
            $table->unsignedBigInteger('gerencia_id');
            $table->text('razon_visita');
            $table->string('foto');     
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('filial_id')->references('id')->on('filiales');
            $table->foreign('gerencia_id')->references('id')->on('gerencias');
        });
    }   
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('visitors');
    }
};

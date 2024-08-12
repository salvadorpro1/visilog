<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVisitorsTable extends Migration
{
    public function up()
    {
        Schema::create('visitors', function (Blueprint $table) {
            $table->id();
            $table->enum('nacionalidad', ['V', 'E']); // Define 'nacionalidad' como enum una sola vez
            $table->string('cedula'); // Define 'cedula' una sola vez
            $table->string('nombre');
            $table->string('apellido');
            $table->unsignedBigInteger('filial_id');
            $table->unsignedBigInteger('gerencia_id');
            $table->text('razon_visita');
            $table->string('foto');
            $table->unsignedBigInteger('user_id');
            $table->timestamps();

            // Foreign keys
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('filial_id')->references('id')->on('filiales')->onDelete('cascade');
            $table->foreign('gerencia_id')->references('id')->on('gerencias')->onDelete('cascade');
        });
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('visitors');
    }
}

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
            $table->string('nacionalidad');
            $table->string('cedula');
            $table->string('nombre');
            $table->string('apellido');
            $table->enum('nacionalidad', ['V', 'E']);
            $table->string('cedula');
            $table->unsignedBigInteger('filial_id');
            $table->unsignedBigInteger('gerencia_id');
            $table->text('razon_visita');
            $table->string('foto');
            $table->unsignedBigInteger('user_id');
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
}

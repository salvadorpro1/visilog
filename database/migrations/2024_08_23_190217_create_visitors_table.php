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
<<<<<<< HEAD:database/migrations/2024_04_23_190217_create_visitors_table.php
=======
            $table->enum('nacionalidad', ['V', 'E']);
            $table->string('cedula');
>>>>>>> recuperacion-commit:database/migrations/2024_08_23_190217_create_visitors_table.php
            $table->unsignedBigInteger('filial_id');
            $table->unsignedBigInteger('gerencia_id');
            $table->text('razon_visita');
            $table->string('foto');
            $table->unsignedBigInteger('user_id');
            $table->timestamps();
<<<<<<< HEAD:database/migrations/2024_04_23_190217_create_visitors_table.php

            $table->foreign('filial_id')->references('id')->on('filiales')->onDelete('cascade');
            $table->foreign('gerencia_id')->references('id')->on('gerencias')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    public function down()
=======

            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('filial_id')->references('id')->on('filiales');
            $table->foreign('gerencia_id')->references('id')->on('gerencias');
        });
    }   
    /**
     * Reverse the migrations.
     */
    public function down(): void
>>>>>>> recuperacion-commit:database/migrations/2024_08_23_190217_create_visitors_table.php
    {
        Schema::dropIfExists('visitors');
    }
}

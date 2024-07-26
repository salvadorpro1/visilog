<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGerenciasTable extends Migration
{
    public function up(): void
    {
        Schema::create('gerencias', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('filial_id');
            $table->string('nombre');
            $table->timestamps();

            $table->foreign('filial_id')->references('id')->on('filiales')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('gerencias');
    }
}

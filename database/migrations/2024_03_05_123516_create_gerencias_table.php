<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('gerencias', function (Blueprint $table) {
            $table->softDeletes();
            $table->id();
            $table->string('nombre');
            $table->unsignedBigInteger('filial_id');
            $table->foreign('filial_id')->references('id')->on('filiales')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('gerencias');
    }
};

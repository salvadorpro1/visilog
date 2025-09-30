<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('visitors', function (Blueprint $table) {
            // Primero eliminamos las foreign keys existentes
            $table->dropForeign(['user_id']);
            $table->dropForeign(['filial_id']);
            $table->dropForeign(['gerencia_id']);
        });

        Schema::table('visitors', function (Blueprint $table) {
            // Hacemos que estas columnas permitan NULL
            $table->unsignedBigInteger('user_id')->nullable()->change();
            $table->unsignedBigInteger('filial_id')->nullable()->change();
            $table->unsignedBigInteger('gerencia_id')->nullable()->change();

            // Creamos las foreign keys de nuevo con SET NULL
            $table->foreign('user_id')
                ->references('id')->on('users')
                ->onDelete('set null');

            $table->foreign('filial_id')
                ->references('id')->on('filiales')
                ->onDelete('set null');

            $table->foreign('gerencia_id')
                ->references('id')->on('gerencias')
                ->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::table('visitors', function (Blueprint $table) {
            // Revertir a CASCADE
            $table->dropForeign(['user_id']);
            $table->dropForeign(['filial_id']);
            $table->dropForeign(['gerencia_id']);
        });

        Schema::table('visitors', function (Blueprint $table) {
            $table->unsignedBigInteger('user_id')->nullable(false)->change();
            $table->unsignedBigInteger('filial_id')->nullable(false)->change();
            $table->unsignedBigInteger('gerencia_id')->nullable(false)->change();

            $table->foreign('user_id')
                ->references('id')->on('users')
                ->onDelete('cascade');

            $table->foreign('filial_id')
                ->references('id')->on('filiales')
                ->onDelete('cascade');

            $table->foreign('gerencia_id')
                ->references('id')->on('gerencias')
                ->onDelete('cascade');
        });
    }
};

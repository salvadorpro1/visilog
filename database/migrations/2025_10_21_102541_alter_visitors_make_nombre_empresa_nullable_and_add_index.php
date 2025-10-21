<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterVisitorsMakeNombreEmpresaNullableAndAddIndex extends Migration
{
    public function up()
    {
        Schema::table('visitors', function (Blueprint $table) {
            // hacer nullable
            $table->string('nombre_empresa')->nullable()->change();

            // índice compuesto para búsquedas por nacionalidad+cedula
            $table->index(['nacionalidad', 'cedula'], 'visitors_nacionalidad_cedula_idx');
        });
    }

    public function down()
    {
        Schema::table('visitors', function (Blueprint $table) {
            $table->string('nombre_empresa')->nullable(false)->change();
            $table->dropIndex('visitors_nacionalidad_cedula_idx');
        });
    }
}

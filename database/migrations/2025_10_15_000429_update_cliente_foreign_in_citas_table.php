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
        Schema::table('citas', function (Blueprint $table) {
            // Primero eliminamos la vieja restricción de clave foránea si existe
            $table->dropForeign(['cliente_id']);

            // Luego volvemos a crear la FK pero apuntando a la tabla person
            $table->foreign('cliente_id')
                ->references('id')
                ->on('person')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('citas', function (Blueprint $table) {
            // revertir al estado anterior (clientes)
            $table->dropForeign(['cliente_id']);

            $table->foreign('cliente_id')
                ->references('id')
                ->on('clientes')
                ->onDelete('cascade');
        });
    }
};

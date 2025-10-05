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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            
            // Campos principales
            $table->string('email')->unique();
            $table->string('password');

            // Estado (A=Activo, E=Eliminado, I=Inactivo)
            $table->enum('status', ['A', 'E', 'I'])->default('A');

            // Campos de auditoría
            $table->timestamp('fecha_ingreso')->nullable();
            $table->unsignedBigInteger('usuario_id')->nullable(); // quién creó
            $table->timestamp('fecha_modifica')->nullable();
            $table->unsignedBigInteger('usuario_modifica_id')->nullable(); // quién modificó
            $table->timestamp('fecha_elimina')->nullable();
            $table->unsignedBigInteger('usuario_elimina_id')->nullable(); // quién eliminó
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};

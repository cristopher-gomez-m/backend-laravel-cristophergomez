<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('cita-detalle', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cita_id')->constrained('citas')->onDelete('cascade');
            $table->foreignId('atencion_id')->constrained('atenciones')->onDelete('cascade');
            $table->enum('status', ['A', 'E', 'I'])->default('A');
            $table->timestamp('fecha_ingreso')->nullable();
            $table->unsignedBigInteger('usuario_id')->nullable();

            $table->timestamp('fecha_modifica')->nullable();
            $table->unsignedBigInteger('usuario_modifica_id')->nullable();

            $table->timestamp('fecha_elimina')->nullable();
            $table->unsignedBigInteger('usuario_elimina_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cita_atencion');
    }
};

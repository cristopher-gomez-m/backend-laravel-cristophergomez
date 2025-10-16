<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // 🔸 Eliminar columnas antiguas que ya no van
            $table->dropColumn([
                'status',
                'fecha_ingreso',
                'usuario_id',
                'fecha_modifica',
                'usuario_modifica_id',
                'fecha_elimina',
                'usuario_elimina_id',
            ]);

            //Agregar nuevas columnas del ERD
            $table->string('user_name')->unique()->after('id')->nullable();
            $table->string('first_name')->nullable()->after('user_name')->nullable();
            $table->string('last_name')->nullable()->after('first_name')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            //Revertir los cambios si se hace rollback
            $table->dropColumn(['user_name', 'first_name', 'last_name']);

            $table->enum('status', ['A', 'E', 'I'])->default('A');
            $table->timestamp('fecha_ingreso')->nullable();
            $table->unsignedBigInteger('usuario_id')->nullable();
            $table->timestamp('fecha_modifica')->nullable();
            $table->unsignedBigInteger('usuario_modifica_id')->nullable();
            $table->timestamp('fecha_elimina')->nullable();
            $table->unsignedBigInteger('usuario_elimina_id')->nullable();
        });
    }
};


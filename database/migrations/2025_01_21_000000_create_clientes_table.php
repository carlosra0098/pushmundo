<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Ejecutar la migración.
     */
    public function up(): void
    {
        if (!Schema::hasTable('clientes')) {
            Schema::create('clientes', function (Blueprint $table) {
                $table->id();
                $table->string('nombre', 100);
                $table->string('apellido', 100);
                $table->string('email', 100)->unique();
                $table->string('telefono', 20);
                $table->string('direccion', 255)->nullable();
                $table->timestamps();

                // Índices para optimizar búsquedas
                $table->index('nombre');
                $table->index('apellido');
                $table->index('email');
            });
        }
    }

    /**
     * Revertir la migración.
     */
    public function down(): void
    {
        Schema::dropIfExists('clientes');
    }
};

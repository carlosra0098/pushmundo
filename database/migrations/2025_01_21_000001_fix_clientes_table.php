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
        // Verificar si la tabla existe y agregar columnas faltantes
        if (Schema::hasTable('clientes')) {
            Schema::table('clientes', function (Blueprint $table) {
                // Agregar columnas si no existen
                if (!Schema::hasColumn('clientes', 'nombre')) {
                    $table->string('nombre', 100)->nullable();
                }
                if (!Schema::hasColumn('clientes', 'apellido')) {
                    $table->string('apellido', 100)->nullable();
                }
                if (!Schema::hasColumn('clientes', 'email')) {
                    $table->string('email', 100)->nullable();
                }
                if (!Schema::hasColumn('clientes', 'telefono')) {
                    $table->string('telefono', 20)->nullable();
                }
                if (!Schema::hasColumn('clientes', 'direccion')) {
                    $table->string('direccion', 255)->nullable();
                }
            });
        }
    }

    /**
     * Revertir la migración.
     */
    public function down(): void
    {
        // No hacer nada en el rollback
    }
};

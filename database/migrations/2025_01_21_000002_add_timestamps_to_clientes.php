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
        // Agregar timestamps si no existen
        if (Schema::hasTable('clientes')) {
            if (!Schema::hasColumn('clientes', 'created_at')) {
                Schema::table('clientes', function (Blueprint $table) {
                    $table->timestamps();
                });
            }
        }
    }

    /**
     * Revertir la migración.
     */
    public function down(): void
    {
        // No hacer nada
    }
};
